<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    return Inertia::render('Dashboard', [
        'path' => $request->query('path')
    ]);
})->name('home');

Route::get('/history', function () {
    return Inertia::render('History');
})->name('history');

Route::post('/select-folder', function () {
    return redirect()->route('home', ['path' => '/Users/Ruslan/Downloads/CleanUp']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
