<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\PlagiarismChecker;


Route::get('/', function () {
    return view('welcome');
})->name('home');



//About Route
Route::get('/about', function () {
    return view('guests.about.index');
})->name('about.index');


Route::get('/check-plagiarism', function () {
    return view('guests.plagiarism.index');
})->name('check-plagiarism');