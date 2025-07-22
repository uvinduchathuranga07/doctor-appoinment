<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'date',
        'details',
        'photopath',
    ];



    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'join_event', 'event_id', 'user_id');
    }


}
