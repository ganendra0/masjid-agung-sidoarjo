<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Study;

class StudyController extends Controller
{
    public function index(ListingRequest $request)
    {
        $q = $request->validated('q');
        $ustadz = $request->validated('ustadz');
        $tema = $request->validated('tema');

        $studies = Study::latestStudied()
            ->search($q)
            ->bySpeaker($ustadz)
            ->byTheme($tema)
            ->paginate(9)
            ->withQueryString();

        return view('studies.index', [
            'studies' => $studies,
            'q' => $q,
            'ustadz' => $ustadz,
            'tema' => $tema,
            'speakers' => Study::published()->distinct()->orderBy('speaker')->pluck('speaker'),
            'themes' => Study::published()->whereNotNull('theme')->distinct()->orderBy('theme')->pluck('theme'),
        ]);
    }

    public function show(string $slug)
    {
        $study = Study::published()->where('slug', $slug)->firstOrFail();

        return view('studies.show', [
            'study' => $study,
            'related' => $study->related(3),
        ]);
    }
}
