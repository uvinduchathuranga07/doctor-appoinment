<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinEvent extends Model
{
    use HasFactory;
     protected $table = 'join_event';

    protected $fillable = [
        'event_id',
        'user_id',
    ];

    /**
     * Relationship to Event
     */
    public function event()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}
