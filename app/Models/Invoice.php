<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'current_state',
        'order_number',
        'order_time',
        'picking_time',
        'confirmation_time',
        'invoice_time',
        'invoice_number',
        'loading_registration',
        'loading_time  ',
        'security_registration',
        'security_time',
        'pod_time'
    ];
}
