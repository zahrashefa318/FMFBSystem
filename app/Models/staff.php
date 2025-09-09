<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Staff extends Authenticatable
{
    protected $table = 'stafftbl';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'role', 'name', 'phone', 'email',
        'hire_date', 'address_id', 'branch_id', 'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($value) {
    $this->attributes['password'] =
        password_get_info($value)['algo'] === 0 ? Hash::make($value) : $value;
}

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'new_id');
    }
}

?>
