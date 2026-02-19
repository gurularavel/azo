<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessageMail;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
        ]);

        $msg = ContactMessage::create($data);

        $adminEmail = SiteSetting::value('contact_email')
            ?? config('mail.from.address');

        try {
            Mail::to($adminEmail)->send(new NewContactMessageMail($msg));
        } catch (\Throwable) {
            // mail failure should not block the redirect
        }

        return redirect()->route('contact')
            ->with('status', 'Mesajınız uğurla göndərildi. Tezliklə sizinlə əlaqə saxlayacağıq!');
    }
}
