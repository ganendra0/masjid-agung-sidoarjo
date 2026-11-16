<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use App\Models\MosqueManager;
use App\Models\MosqueProfile;

class ProfileController extends Controller
{
    public function show(MosqueProfile $profile, ContactSetting $contact)
    {
        return view('profile.show', [
            'profile' => $profile,
            'contact' => $contact,
            'managers' => MosqueManager::active()->get(),
            'facilities' => collect($profile->facilities ?? [])->filter(fn ($f) => filled($f['name'] ?? null))->values(),
        ]);
    }
}
