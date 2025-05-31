<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;

Route::get('/send-test-email', function () {
    $taskName = "Simple Test Task";
    $email = "jonalyndelima96@gmail.com"; // Use your Mailtrap inbox email

    Mail::to($email)->send(new TaskAssignedMail($taskName));

    return "Test email sent!";
});

