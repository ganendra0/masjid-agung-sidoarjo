<?php

namespace App\Providers;

use App\Models\ContactSetting;
use App\Models\MosqueProfile;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Singleton per-request: profil & kontak dipakai di layout dan halaman, cukup 1 query.
        $this->app->singleton(MosqueProfile::class, fn () => MosqueProfile::current());
        $this->app->singleton(ContactSetting::class, fn () => ContactSetting::current());
    }

    public function boot(): void
    {
        Carbon::setLocale('id');
        Paginator::defaultView('vendor.pagination.site');

        View::composer(['news.*', 'agenda.*', 'studies.*', 'gallery.*'], function ($view) {
            $view->with([
                'profile' => app(MosqueProfile::class),
                'contact' => app(ContactSetting::class),
            ]);
        });

        View::composer('layouts.app', function ($view) {
            $view->with([
                'profile' => app(MosqueProfile::class),
                'contact' => app(ContactSetting::class),
                'menu' => [
                    ['label' => 'Beranda', 'route' => 'home', 'active' => 'home'],
                    ['label' => 'Profil', 'route' => 'profile', 'active' => 'profile'],
                    ['label' => 'Berita', 'route' => 'news.index', 'active' => 'news.*'],
                    ['label' => 'Agenda', 'route' => 'agenda.index', 'active' => 'agenda.*'],
                    ['label' => 'Kajian', 'route' => 'studies.index', 'active' => 'studies.*'],
                    ['label' => 'Galeri', 'route' => 'gallery.index', 'active' => 'gallery.*'],
                    ['label' => 'Kontak', 'route' => 'contact', 'active' => 'contact'],
                ],
            ]);
        });
    }
}
