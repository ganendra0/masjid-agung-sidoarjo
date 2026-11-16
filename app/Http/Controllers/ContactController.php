<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use App\Models\MosqueProfile;

class ContactController extends Controller
{
    public function show(MosqueProfile $profile, ContactSetting $contact)
    {
        return view('contact.show', compact('profile', 'contact'));
    }
}
