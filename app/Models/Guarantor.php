<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    
    protected $tabel='loan_guarantors';
    protected $primarykey='guarantor_id';
    protected $fillable=['guarantor_name','relationship','phone','email','id_number'];

    public function loanaccount(){
        return $this->belongsTo(LoanAccount::class,'loan_id');
    }

    public function address(){
        return $this->belongsTo(Address::class,'address_id');
     }
}
