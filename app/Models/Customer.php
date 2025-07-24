<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $table = 'customer_tbl';
     protected $primaryKey = 'customer_id'; 
     protected $fillable = ['first_name', 'last_name','social_security_num','phone','email','type_of_business','time_in_business','business_phone','registrationdate','status','active_loan_account','staff_username','branch_id','address_id' ];

     public function address(){
        return $this->belongsTo(Address::class,'address_id');
     }

     public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'new_id');
     }

     public function staff(){
        return $this->belongsTo(Staff::class, 'staff_username', 'username');
     }
     
     public function loanaccount(){
        return $this->belongsTo(LoanAccount::class, 'active_loan_account','loan_id');
     }
     

}

