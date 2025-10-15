<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventConfirmationController extends Controller
{
    public function confirm(string $token)
    {
        $event = Event::where('confirmation_token', $token)->firstOrFail();
        $event->update(['confirmed_at' => now()]);

        return view('panel.events.confirmed', compact('event'));
    }
}


