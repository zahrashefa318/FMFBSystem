<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business_info extends Model
{
    protected $table = 'business_info';
    protected $primaryKey = 'id';
    protected $fillable=[' business_name','legal_structure','address_id','customer_id',' phone','email'];

    public function address(){
        return $this->belongsTo(Address::class,'address_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

}
?>