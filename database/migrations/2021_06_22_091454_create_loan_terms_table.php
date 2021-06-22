<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_terms', function (Blueprint $table) {
            $table->id();

            /*
                0 - 4  weeks => 15%
                5 - 8  weeks => 14%
                9 - 16 weeks => 12%
            */

            $table->unsignedSmallInteger('start_weeks');
            $table->unsignedSmallInteger('end_weeks');
            $table->float('interest', 6, 2);


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
        Schema::dropIfExists('loan_terms');
    }
}
