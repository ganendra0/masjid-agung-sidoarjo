<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/profil', [ProfileController::class, 'show'])->name('profile');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{slug}', [AgendaController::class, 'show'])->name('agenda.show');

Route::get('/kajian', [StudyController::class, 'index'])->name('studies.index');
Route::get('/kajian/{slug}', [StudyController::class, 'show'])->name('studies.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/kontak', [ContactController::class, 'show'])->name('contact');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
