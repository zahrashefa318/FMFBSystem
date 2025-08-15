<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LoanApplication extends Model
{
    protected $table = 'loan_applications';    // FIX: $table, not $tabel
    protected $primaryKey = 'application_id';  // FIX: $primaryKey
    protected $fillable = [
        'customer_id','requested_amount','terms_months',
        'application_submit_date','notes','status','business_id',
        'purpose','frequency','interest_rate',
        'guarantor_signature','customer_signature'
    ];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function business()
    {
        // if Business_info PK is business_id (recommended), set owner key:
        return $this->belongsTo(Business_info::class, 'business_id', 'id');
    }

    public function collaterals()
    {
        return $this->hasMany(Collateral::class, 'application_id', 'application_id');
    }
}
