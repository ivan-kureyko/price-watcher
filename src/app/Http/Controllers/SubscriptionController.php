<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    public function store(
        StoreSubscriptionRequest $request,
        SubscriptionService $subscriptionService
    ) {
        $subscriptionService->create(
            $request->email,
            $request->url
        );

        return response()->json([
            'message' => 'Subscription created successfully',
        ]);
    }

    public function storeFromWeb(
        StoreSubscriptionRequest $request,
        SubscriptionService $subscriptionService
    ) {
        $subscriptionService->create(
            $request->email,
            $request->url
        );

        return redirect()
            ->back()
            ->with('success', 'Subscription created successfully.');
    }
}
