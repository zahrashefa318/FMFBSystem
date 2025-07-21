<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'new_id'; 
    protected $fillable = ['branch_name', 'branch_phone','branch_email'];
    
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

}
