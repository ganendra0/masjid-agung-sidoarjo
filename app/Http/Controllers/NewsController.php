<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\News;
use App\Models\NewsCategory;

class NewsController extends Controller
{
    public function index(ListingRequest $request)
    {
        $q = $request->validated('q');
        $kategori = $request->validated('kategori');

        $news = News::with('category')
            ->latestPublished()
            ->search($q)
            ->inCategory($kategori)
            ->paginate(9)
            ->withQueryString();

        return view('news.index', [
            'news' => $news,
            'q' => $q,
            'kategori' => $kategori,
            'categories' => NewsCategory::whereHas('news', fn ($n) => $n->published())->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $news = News::with(['category', 'author'])->published()->where('slug', $slug)->firstOrFail();

        return view('news.show', [
            'news' => $news,
            'related' => $news->related(3)->load('category'),
        ]);
    }
}
