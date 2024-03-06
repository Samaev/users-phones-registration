<?php

namespace App\Http\Controllers\User;

use Aloha\Twilio\Twilio;
use App\Http\Controllers\Controller;
use Twilio\Rest\Client;
use App\Mail\RegistrationConfirmation;
use App\Models\PhoneBook;
use App\Models\User;
use App\Models\UserCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ShowController extends BaseController
{
    public function __invoke()
    {
        return User::with(['userCountry', 'phoneBook'])->get();

    }
}
