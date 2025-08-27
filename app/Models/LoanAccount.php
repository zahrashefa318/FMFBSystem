<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    // Correct spelling: use $table, not $tabel
    protected $table = 'loan_accounts';

    // Correct property casing: primaryKey (capital K)
    protected $primaryKey = 'loan_id';

    // Optional: if loan_id is NOT auto-incrementing, set incrementing = false
    // public $incrementing = true;

    // Timestamp constants are fine if table columns are named createdOn & modifiedAt
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'modifiedAt';

    protected $fillable = [
        'customer_id',
        'total_loan_given',
        'duration',
        'start_date',
        'end_date',
        'status',
        'interest_rate',
        // timestamps can be excluded here for security, Laravel handles them automatically
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
?>