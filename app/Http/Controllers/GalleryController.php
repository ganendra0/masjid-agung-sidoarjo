<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Gallery;
use App\Models\GalleryCategory;

class GalleryController extends Controller
{
    public function index(ListingRequest $request)
    {
        $kategori = $request->validated('kategori');

        return view('gallery.index', [
            'galleries' => Gallery::with('category')->latestTaken()->inCategory($kategori)->paginate(16)->withQueryString(),
            'kategori' => $kategori,
            'categories' => GalleryCategory::whereHas('galleries', fn ($g) => $g->published())->orderBy('name')->get(),
        ]);
    }
}
