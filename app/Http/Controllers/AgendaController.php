<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Agenda;
use App\Models\AgendaCategory;

class AgendaController extends Controller
{
    public function index(ListingRequest $request)
    {
        $tab = $request->validated('tab') ?? 'mendatang';
        $kategori = $request->validated('kategori');
        $tanggal = $request->validated('tanggal');

        $query = Agenda::with('category')->published()->inCategory($kategori)->onDate($tanggal);
        $query = $tab === 'selesai' ? $query->past() : $query->upcoming();

        return view('agenda.index', [
            'agendas' => $query->paginate(9)->withQueryString(),
            'tab' => $tab,
            'kategori' => $kategori,
            'tanggal' => $tanggal,
            'categories' => AgendaCategory::whereHas('agendas', fn ($a) => $a->published())->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $agenda = Agenda::with('category')->published()->where('slug', $slug)->firstOrFail();

        return view('agenda.show', [
            'agenda' => $agenda,
            'others' => Agenda::with('category')->published()->upcoming()->whereKeyNot($agenda->id)->limit(3)->get(),
        ]);
    }
}
