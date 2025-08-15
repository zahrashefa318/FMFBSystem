<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collateral extends Model
{
    protected $table = 'loan_collateral';
    protected $primaryKey = 'collateral_id';
    protected $fillable = [
        'collateral_type','description','estimated_value',
        'document_reference','status','application_id'
    ];
    public $timestamps = false; // if your table lacks timestamps  :contentReference[oaicite:3]{index=3}

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'application_id', 'application_id');
    }
}
