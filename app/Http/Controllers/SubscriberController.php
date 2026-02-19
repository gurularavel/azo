<?php

namespace App\Http\Controllers;

use App\Mail\NewSubscriberMail;
use App\Models\Subscriber;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:191'],
        ]);

        $subscriber = Subscriber::firstOrCreate(['email' => $data['email']]);

        if ($subscriber->wasRecentlyCreated) {
            $adminEmail = SiteSetting::value('contact_email')
                ?? config('mail.from.address');

            try {
                Mail::to($adminEmail)->send(new NewSubscriberMail($subscriber));
            } catch (\Throwable) {
                // mail failure should not break the user flow
            }
        }

        return back()->with('subscriber_success', true);
    }
}
