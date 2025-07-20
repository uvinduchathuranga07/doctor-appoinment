<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'product_ids',
        'payment_status',
        'prescription_id',
        'pharmacy_name',
        'status',
        'notes',
        'total_price',
    ];

    protected $casts = [
        'product_ids' => 'array'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
