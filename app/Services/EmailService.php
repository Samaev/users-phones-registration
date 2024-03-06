<?php

namespace App\Services;

use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendRegistrationConfirmation($email, $user)
    {
        Mail::to($email)->send(new RegistrationConfirmation($user));
    }
}
