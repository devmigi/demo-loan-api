<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->float('amount', 10, 2);
            $table->unsignedSmallInteger('tenure'); // in weeks
            $table->float('interest', 6, 2);

            $table->enum('status', ['applied', 'approved', 'rejected', 'closed']);

            $table->foreignId('approver_id')->nullable()->constrained('users')
                ->onUpdate('cascade')->onDelete('set null');  // person(admin) who has approved the loan

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
        Schema::dropIfExists('loan_applications');
    }
}
