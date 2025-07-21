<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'stafftbl';
    protected $primaryKey = 'username'; 
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['role', 'name','phone','email','hire_date','address_id','branch_id'];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

     public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id','new_id');
    }
}
