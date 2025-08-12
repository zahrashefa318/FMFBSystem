<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $tabel='loan_applications';
    protected $primarykey='application_id';
    protected $fillable=['customer_id','requested_amount','terms_months','application_submit_date','notes','status','business_id','purpose','frequency','interest_rate','guarantor_signature','customer_signature'];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
