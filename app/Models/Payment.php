<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function rent() {
        return $this->belongsTo(Rent::class);
    }
    
    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    
    public function getRouteKeyName() {
        return 'reference_number';
    }

    
    public function getPaymentInfo($rent_number) {
        return $this->
        join('rents', 'rents.id', '=', 'payments.rent_id')
        ->select('payments.id', 'payments.rent_id', 'payments.reference_number', 'payments.nominal', 'payments.created_at', 'payments.updated_at')
        ->where('rent_number', $rent_number)
        ->get();
    }
}
