<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'transaction_id',
        'gross_amount',
        'currency',
        'payment_type',
        'transaction_status',
        'fraud_status',
        'customer_name',
        'customer_email'
    ];
}
