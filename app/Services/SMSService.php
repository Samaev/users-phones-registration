<?php

namespace App\Services;

use Twilio\Rest\Client;

class SMSService
{
    public function sendRegistrationConfirmation($phoneNumber, $message)
    {
        $account_sid = "ACa600d87e517168502c90908bdb0254a0";

//    TODO: this token is being revoked every time I publish code to GitHUB by security rules
        $auth_token = "182be7eedfceb615b1ac890f8b6c2f09";
        $twilio_number = "+15169906171";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $phoneNumber,
            [
                'from' => $twilio_number,
                'body' => $message
            ]
        );
    }
}
