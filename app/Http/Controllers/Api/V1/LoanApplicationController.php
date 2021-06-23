<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\LoanApplicationResource;
use App\Models\LoanApplication;
use App\Models\LoanTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanApplicationController extends ApiController
{
    /**
     * Display all loan applications of a user
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userLoans = LoanApplication::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return $this->sendResponse(['loanApplications' => LoanApplicationResource::collection($userLoans)], 'User Loan Applications');
    }


    /**
     * Save new loan application
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'tenure_in_weeks' => 'required|max:999|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed.',  $validator->errors(), 422);
        }

        $user = $request->user();
        $input = $request->all();



        // get interest rate from loan_terms table
        $tenure = LoanTerm::where([
            ['start_weeks', '<=', $input['tenure_in_weeks']],
            ['end_weeks', '>=', $input['tenure_in_weeks']]
        ])->first();


        $loan = new LoanApplication();
        $loan->user_id = $user->id;
        $loan->amount = $input['amount'];
        $loan->tenure = $input['tenure_in_weeks'];
        $loan->interest = $tenure->interest;
        $loan->status = 'applied';

        if($loan->save()){
            return $this->sendResponse(['success' => true], 'Loan Request submitted.');
        }

        return $this->sendError('Failed to submit loan application', [], 500);
    }

}
