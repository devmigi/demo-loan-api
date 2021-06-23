<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }


    public function loan()
    {
        return $this->belongsTo('App\Models\LoanApplication', 'loan_id', 'id');
    }

}
