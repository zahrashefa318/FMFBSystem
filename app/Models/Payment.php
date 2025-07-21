<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $tabel='loan_repayment';
    protected $primarykey='payment_id';
    protected $fillable=['payment_date','amount_paid','principle_paid','interest_paid','remaining_balance','payment_method'];

     public function loanaccount(){
        return $this->belongsTo(LoanAccount::class,'loan_id');
     }
     
}
