<?php
/**
 * Created by PhpStorm.
 * User: mrigendra
 * Date: 22/06/21
 * Time: 11:47 PM
 */

namespace App\Services;


use App\Models\LoanApplication;
use App\Models\LoanRepayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoanApplicationService
{

    /**
     * Process Loan
     * @param LoanApplication $loan
     * @param $approved
     * @return bool
     */
    public function processLoan(LoanApplication $loan, $approved, $approverId){

        DB::beginTransaction();
        try {
            if(!$approved) {
                $loan->status = "rejected";
                $loan->approver_id = $approverId;
                $loan->save();
            }
            else{
                $loan->status = "approved";
                $loan->approver_id = $approverId;
                $loan->save();

                // store loan repayment schedules (Weekly)
                $loanRepayments = $this->getWeeklyLoanRepayments($loan);
                LoanRepayment::insert($loanRepayments);
            }

            DB::commit();

            return true;
        }
        catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return false;
        }
    }


    /**
     * Helper to get loan repayments
     * @param LoanApplication $loan
     * @return array
     */
    public function getWeeklyLoanRepayments(LoanApplication $loan){


        $paymentAmount = $loan->amount + ($loan->amount * $loan->interest * ($loan->tenure / 52) * 0.01); // simple interest = P + (P * T * R) / 100;

        $paymentDate = Carbon::today()->startOfWeek(); // current week monday
        $loanRepayments = [];

        for($i=1; $i <= $loan->tenure; $i++){
            $loanRepayments[] = [
                'user_id' => $loan->user_id,
                'loan_id' => $loan->id,
                'instalment' => $i,
                'emi_amount' => $paymentAmount / $loan->tenure ,
                'due_date' => $paymentDate->addWeeks(1)->toDateTimeString(),
            ];
        }

        return $loanRepayments;
    }

}