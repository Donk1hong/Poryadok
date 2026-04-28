<?php

use App\Http\Controllers\AiController;
use App\Models\History;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Native\Laravel\Dialog;

Route::get('/', function (Request $request) {
    return Inertia::render('Dashboard', [
        'path' => $request->query('path')
    ]);
})->name('dashboard');

Route::get('/history', function () {
    return Inertia::render('History', [
        'history' => History::latest()->get()
    ]);
})->name('history');

Route::post('/select-folder', function () {
    $path = Dialog::new()
        ->folders()
        ->title('Выберите директорию для сортировки')
        ->open();

    if ($path) {
        return redirect()->route('dashboard', ['path' => $path]);
    }

    return redirect()->route('dashboard');
});

Route::post('/analyze', [AiController::class, 'analyze'])->name('ai.analyze');
