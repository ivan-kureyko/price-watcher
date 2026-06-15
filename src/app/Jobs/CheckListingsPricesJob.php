<?php

namespace App\Jobs;

use App\Mail\PriceChangedMail;
use App\Models\Listing;
use App\Services\OlxPriceParser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CheckListingsPricesJob implements ShouldQueue
{
    use Queueable;

    public function handle(OlxPriceParser $parser): void
    {
        Listing::query()->each(function (Listing $listing) use ($parser) {
            $this->checkListing($listing, $parser);
        });
    }

    /**
     * Run queue.
     */
    private function checkListing(Listing $listing, OlxPriceParser $parser): void
    {
        $response = Http::get($listing->url);

        if (! $response->successful()) {
            return;
        }

        $price = $parser->parse($response->body());
        $oldPrice = $listing->current_price;

        if ($price === null) {
            return;
        }

        $data = ['last_checked_at' => now()];

        if ($oldPrice === null) {
            $data['current_price'] = $price;
        } elseif ((float) $oldPrice !== (float) $price) {
            $data['current_price'] = $price;
            $this->sendEmails($listing, (float) $oldPrice, (float) $price);
        }

        $listing->update($data);
    }

    private function sendEmails(Listing $listing, float $oldPrice, float $price): void
    {
        foreach ($listing->subscriptions as $subscription) {
            Mail::to($subscription->email)->send(
                new PriceChangedMail($listing, $oldPrice, $price)
            );
        }
    }

    public function middleware(): array
    {
        return [
            new WithoutOverlapping('check-listings-prices'),
        ];
    }
}
