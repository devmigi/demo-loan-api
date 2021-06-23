<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\LoanApplicationResource;
use App\Models\LoanApplication;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanRepaymentController extends ApiController
{
    /**
     * Display loan emis
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userLoanRepayments = LoanApplication::with('repayments')->where([
                ['user_id', $request->user()->id],
                ['status', 'approved'],
            ])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();


        $currentPendingRepayments = LoanRepayment::where([
            ['user_id', $request->user()->id],
            ['due_date', '<', Carbon::now()],
            ['status', 'pending'],
        ])
            ->orderByDesc('created_at')
            ->get();


        return $this->sendResponse(['pendingRepayment' => $currentPendingRepayments, 'activeLoan' => LoanApplicationResource::collection($userLoanRepayments)], 'User Loan Repayments');
    }


    /**
     * Repay an instalment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function repay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emi_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed.',  $validator->errors(), 422);
        }

        $input = $request->all();

        $repayment = LoanRepayment::where([
            ['id', $input['emi_id']],
            ['user_id', $request->user()->id]
        ])->with('loan')->first();


        if (!$repayment) {
            return $this->sendError('Emi does not exists.',  [], 422);
        }
        else if ($repayment->status == 'paid') {
            return $this->sendError('Emi already paid.',  [], 422);
        }

        $repayment->status = 'paid';
        $repayment->paid_amount = $repayment->emi_amount;
        $repayment->payment_date = Carbon::now();

        // close loan if last installment is paid
        if($repayment->loan->tenure == $repayment->instalment){
            LoanApplication::where('id', $repayment->loan_id)
                ->update(['status' => 'closed']);
        }

        if($repayment->save()){
            return $this->sendResponse(['success' => true], 'EMI paid successfully.');
        }

        return $this->sendError('Failed to pay EMI', [], 500);
    }

}
