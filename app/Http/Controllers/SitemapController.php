<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\News;
use App\Models\Study;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $urls = collect(['home', 'profile', 'news.index', 'agenda.index', 'studies.index', 'gallery.index', 'contact'])
                ->map(fn ($name) => ['loc' => route($name), 'lastmod' => null]);

            $urls = $urls
                ->concat(News::published()->get(['slug', 'updated_at'])
                    ->map(fn ($m) => ['loc' => route('news.show', $m->slug), 'lastmod' => $m->updated_at?->toAtomString()]))
                ->concat(Agenda::published()->get(['slug', 'updated_at'])
                    ->map(fn ($m) => ['loc' => route('agenda.show', $m->slug), 'lastmod' => $m->updated_at?->toAtomString()]))
                ->concat(Study::published()->get(['slug', 'updated_at'])
                    ->map(fn ($m) => ['loc' => route('studies.show', $m->slug), 'lastmod' => $m->updated_at?->toAtomString()]));

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots()
    {
        $body = "User-agent: *\nDisallow: /admin\n\nSitemap: ".route('sitemap')."\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
