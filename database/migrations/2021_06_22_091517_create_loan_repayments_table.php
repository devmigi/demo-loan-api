<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->foreignId('loan_id')->nullable()->constrained('loan_applications')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedSmallInteger('instalment'); // 1st, 2nd, 3rd etc.
            $table->float('emi_amount', 10, 2);

            $table->dateTime('due_date');
            $table->dateTime('payment_date')->nullable();

            $table->float('paid_amount', 10, 2)->nullable();

            $table->enum('status', ['due', 'paid', 'partially_paid']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_repayments');
    }
}
