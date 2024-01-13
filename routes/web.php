<?php

use App\Livewire\ParticipantIndex;
use App\Livewire\Sweepstake;
use App\Livewire\WhatsApp;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', ParticipantIndex::class)->name('index');
Route::get('/sorteio', Sweepstake::class)->name('sweepstake');
Route::get('/whatsapp', WhatsApp::class)->name('whatsapp');
