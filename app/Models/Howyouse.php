<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Howyouse extends Model
{
    use HasFactory;

    protected $table = 'howyouse';

    protected $fillable = [
        'dosage_instructions',
        'side_effects',
        'precaution',
        'interaction',
        'storage',
        'brand_names',
        'product_id',
    ];

    /**
     * Relationship: belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
