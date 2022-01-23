<?php

namespace App\Http\Controllers;

use App\Services\KlaviyoService;
use Illuminate\Support\Facades\Auth;

class TrackActivity extends Controller
{
    public function trackme() {
        (new KlaviyoService())->EventTrackingService->trackButtonClicked(Auth::user());

        return redirect()->back();
    }
}
