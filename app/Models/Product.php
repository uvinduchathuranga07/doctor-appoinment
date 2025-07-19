<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'details',
        'photopath',
        'stock_count',
    ];
    public function howyouse()
{
    return $this->hasOne(Howyouse::class);
}

}
