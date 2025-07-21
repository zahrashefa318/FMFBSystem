<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    protected $table='payment_schedule';
    protected $primaryKey='schedule_id';
    protected $fillable=['due_date','scheduled_amount','principal_component','interest_component','status'];

     public function payment(){
        return $this->belongsTo(Payment::class,'actual_payment_id','payment_id');
     }
}
