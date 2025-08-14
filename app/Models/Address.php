<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'address_id'; 
    protected $fillable = ['street', 'city','state', 'zipcode'];

    public function customers()
{
    return $this->hasMany(Customer::class, 'address_id', 'address_id');
}
}
 

