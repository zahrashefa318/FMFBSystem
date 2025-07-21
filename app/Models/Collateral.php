<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collateral extends Model
{
    protected $table = 'loan_collateral';
    protected $primaryKey = 'collateral_id';
    protected $fillable=['collateral_type','description','estimated_value','document_reference','status'];

    public function loanaccount(){
        return $this->belongsTo(LoanAccount::class,'loan_id');
    }

}
