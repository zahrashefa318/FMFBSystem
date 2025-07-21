<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $tabel='loan_applications';
    protected $primarykey='application_id';
    protected $fillable=['requested_amount','terms_months','application_submit_date','notes','status'];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
