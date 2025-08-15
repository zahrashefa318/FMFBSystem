<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $table = 'loan_guarantors';      // FIX: $table, not $tabel
    protected $primaryKey = 'guarantor_id';    // FIX: $primaryKey, not $primarykey
    protected $fillable = ['guarantor_name','relationship','phone','email','address_id','customer_id'];
    public $timestamps = false;

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function customer()
    {
        // Your create() code earlier sets customer_id, so relate to Customer
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Only keep this if loan_guarantors has loan_id column:
    // public function loanaccount()
    // {
    //     return $this->belongsTo(LoanAccount::class, 'loan_id', 'loan_id');
    // }
}

    
