<?php

namespace Database\Seeders;

use App\Models\LoanApplication;
use Illuminate\Database\Seeder;

class LoanApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanApplication::create(
            [
                'user_id' => 1,
                'amount' => 12000,
                'tenure' => 12,
                'interest' => 16.0,
            ]
        );

        LoanApplication::create(
            [
                'user_id' => 1,
                'amount' => 24000,
                'tenure' => 24,
                'interest' => 14.0,
            ]
        );

        LoanApplication::create(
            [
                'user_id' => 2,
                'amount' => 50000,
                'tenure' => 10,
                'interest' => 16.0,
            ]
        );

        LoanApplication::create(
            [
                'user_id' => 2,
                'amount' => 36000,
                'tenure' => 12,
                'interest' => 16.0,
            ]
        );

    }
}
