<?php

namespace App\Http\Controllers\User;

use Aloha\Twilio\Twilio;
use App\Http\Controllers\Controller;
use App\Services\EmailService;
use App\Services\SMSService;
use Twilio\Rest\Client;
use App\Mail\RegistrationConfirmation;
use App\Models\PhoneBook;
use App\Models\User;
use App\Models\UserCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CreateController extends BaseController
{
    public function __invoke(Request $request, EmailService $emailService,SMSService $smsService)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->fullName,
                'email' => $request->email,
            ]);

            if (!empty($request->selectedCountry)) {
                UserCountry::create([
                    'user_id' => $user->id,
                    'country' => $request->selectedCountry,
                ]);
            }

            if (!empty($request->phoneNumber)) {
                PhoneBook::create([
                    'user_id' => $user->id,
                    'phone_number' => $request->phoneNumber,
                ]);
            }

            DB::commit();

            $emailService->sendRegistrationConfirmation($request->email, $user);
            $message = "Congratulation! Your registration confirmed!";
            $smsService->sendRegistrationConfirmation($request->phoneNumber, $message);
            return 'OK';
        } catch (\Exception $e) {
            DB::rollBack();
            return 'Error here: ' . $e->getMessage();
        }

    }
}
