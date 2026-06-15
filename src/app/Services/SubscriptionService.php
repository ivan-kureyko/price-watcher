<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\Subscription;

class SubscriptionService
{
    public function create(string $email, string $url): void
    {
        $listing = Listing::firstOrCreate([
            'url' => $url,
        ]);

        Subscription::firstOrCreate([
            'listing_id' => $listing->id,
            'email' => $email,
        ]);
    }
}
