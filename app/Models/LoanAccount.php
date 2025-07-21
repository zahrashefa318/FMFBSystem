<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    protected $tabel='loan_accounts';
    protected $primarykey='loan_id';
    protected $fillable=['total_loan_given','duration','start_date','end_date','created_at','status'];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }



}
