<?php

namespace App\Http\Controllers;

use App\Services\KlaviyoClient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TrackActivity extends Controller
{
    public function trackme(KlaviyoClient $client)
    {
        $client->eventTrackingService->trackButtonClicked(Auth::user());

        return redirect()->back();
    }
}
