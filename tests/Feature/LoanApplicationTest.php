<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoanApplicationTest extends TestCase
{

    /**
     * Test unauthenticated failed loan application
     *
     * @return void
     */
    public function testUnauthenticatedFailedLoanApplication()
    {

        $loanApplicationData = [
            "amount" => rand(1000, 50000),
            "tenure_in_weeks" => rand(1, 100)
        ];


        $this->json('POST', 'api/v1/loans', $loanApplicationData, ['Accept' => 'application/json'])
            ->assertStatus(403)
            ->assertJson([
                "message" => "Unauthenticated.",
                "code" => 403
            ], false);

    }



    /**
     * Test validation for loan application
     *
     * @return void
     */
    public function testValidationForLoanApplication()
    {
        $user = User::factory()->create();
        Sanctum::actingAs( $user, ['*'] );

        $loanApplicationData = [];


        $this->json('POST', 'api/v1/loans', $loanApplicationData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Validation failed.",
                "data" => [
                    "tenure_in_weeks" => ["The tenure in weeks field is required."],
                    "amount" => ["The amount field is required."],
                ]
            ]);

    }


    /**
     * Test Successfull loan application
     *
     * @return void
     */
    public function testSuccessfulLoanApplication()
    {

        $user = User::factory()->create();
        Sanctum::actingAs( $user, ['*'] );

        $loanApplicationData = [
            "amount" => rand(1000, 50000),
            "tenure_in_weeks" => rand(1, 100)
        ];


        $this->json('POST', 'api/v1/loans', $loanApplicationData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "message" => "Loan Request submitted.",
                "code" => 200,
                "data" => [
                    "success" => true
                ]
            ]);

        $this->assertDatabaseHas('loan_applications', [
            'user_id' => $user->id,
            'amount' => $loanApplicationData['amount'],
            'tenure' => $loanApplicationData['tenure_in_weeks'],
        ]);

    }



}
