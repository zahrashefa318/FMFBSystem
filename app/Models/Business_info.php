<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business_info extends Model
{
    protected $table = 'business_info';
    protected $primaryKey = 'id'; // <- change to your real PK
    protected $fillable = ['business_name','legal_structure','address_id','customer_id','phone','email'];
    public $timestamps = false; // if no created_at/updated_at  :contentReference[oaicite:6]{index=6}

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id'); // fk, ownerKey
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    // Often useful:
    public function loanApplications()
    {
        return $this->hasMany(LoanApplication::class, 'business_id', 'id');
    }
}

?>