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


class DestroyController extends BaseController
{
    public function __invoke(Request $request)
    {
        try {
            $userId = $request->input('id');
            $user = User::findOrFail($userId);
            $user->userCountry()->delete();
            $user->phoneBook()->delete();
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }

    }
}
