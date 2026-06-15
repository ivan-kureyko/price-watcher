<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'listing_id',
        'email',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
