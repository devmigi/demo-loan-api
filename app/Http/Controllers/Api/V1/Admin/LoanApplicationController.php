<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\LoanApplicationResource;
use App\Models\LoanApplication;
use App\Services\LoanApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanApplicationController extends ApiController
{
    /**
     *
     * @var LoanApplicationService
     */
    protected $loanService;


    /**
     * Create a new controller instance.
     *
     * @param  LoanApplicationService  $loanService
     * @return void
     */
    public function __construct(LoanApplicationService $loanService)
    {
        $this->loanService = $loanService;
    }


    /**
     * ADMIN - Get loan details API
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanApplication = LoanApplication::where('id', $id)->with('user')->first();

        return $this->sendResponse(['loanApplication' => new LoanApplicationResource($loanApplication)], 'Loan Application Detail');
    }


    /**
     * ADMIN - Approve/Reject loan application API
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'approve' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed.',  $validator->errors(), 422);
        }

        $loan = LoanApplication::where('id', $id)->first();

//        // show error if loan was already processed
//        if($loan->status != 'applied'){
//            return $this->sendError('Loan was already processed', [], 422);
//        }


        $processed = $this->loanService->processLoan($loan, $request->input('approve'));


        if($processed){
            return $this->sendResponse(['success' => true], 'Loan Details Updated.');
        }

        return $this->sendError('Failed to submit loan application', [], 500);

    }


}
