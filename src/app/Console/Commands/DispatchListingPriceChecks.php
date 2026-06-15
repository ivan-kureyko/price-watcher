<?php

namespace App\Console\Commands;

use App\Jobs\CheckListingsPricesJob;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('prices:dispatch-checks')]
#[Description('Dispatch price check jobs for all listings')]
class DispatchListingPriceChecks extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        CheckListingsPricesJob::dispatch();

        $this->info('Price check jobs dispatched.');

        return self::SUCCESS;
    }
}
