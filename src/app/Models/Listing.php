<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'url',
        'current_price',
        'last_checked_at',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
