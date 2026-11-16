<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\ContactSetting;
use App\Models\Gallery;
use App\Models\HeroBanner;
use App\Models\MosqueProfile;
use App\Models\News;
use App\Models\Study;

class HomeController extends Controller
{
    public function __invoke(MosqueProfile $profile, ContactSetting $contact)
    {
        $agendas = Agenda::with('category')->published()->upcoming()->limit(3)->get();
        $agendasAreUpcoming = $agendas->isNotEmpty();

        // Bila belum ada agenda mendatang, tampilkan yang terakhir terlaksana agar section tidak kosong.
        if (! $agendasAreUpcoming) {
            $agendas = Agenda::with('category')->published()->past()->limit(3)->get();
        }

        $galleries = Gallery::with('category')->latestTaken()->limit(8)->get();

        return view('home.index', [
            'profile' => $profile,
            'contact' => $contact,
            'banners' => HeroBanner::active()->get(),
            'agendas' => $agendas,
            'agendasAreUpcoming' => $agendasAreUpcoming,
            'news' => News::with('category')->latestPublished()->limit(3)->get(),
            'studies' => Study::latestStudied()->limit(3)->get(),
            'galleries' => $galleries,
            'galleryCategories' => $galleries->pluck('category')->filter()->unique('id')->values(),
        ]);
    }
}
