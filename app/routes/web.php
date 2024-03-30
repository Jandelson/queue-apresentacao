<?php

use App\Jobs\SendWelcomeEmailJob;
use App\Mail\SendEmailWelcome;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('teste-queue-email', function () {
    $details['name'] = 'Jandelson';
    $details['email'] = 'jandelson@jandelson.com.br';
    SendWelcomeEmailJob::dispatch($details);
    dd('sent');
})->name('teste-queue-email');