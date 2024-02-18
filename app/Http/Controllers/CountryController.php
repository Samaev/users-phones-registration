<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use Twilio\Rest\Client;
use App\Mail\RegistrationConfirmation;
use App\Models\PhoneBook;
use App\Models\User;
use App\Models\UserCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CountryController extends Controller
{
    public $emojiToCode = [
        '🇧🇳' => 'BN',
        '🇵🇸' => 'PS',
        '🇧🇧' => 'BB',
        '🇷🇺' => 'RU',
        '🇳🇨' => 'NC',
        '🇹🇷' => 'TR',
        '🇨🇳' => 'CN',
        '🇩🇰' => 'DK',
        '🇭🇷' => 'HR',
        '🇨🇦' => 'CA',
        '🇸🇾' => 'SY',
        '🇷🇼' => 'RW',
        '🇲🇷' => 'MR',
        '🇵🇷' => 'PR',
        '🇳🇮' => 'NI',
        '🇨🇬' => 'CG',
        '🇮🇹' => 'IT',
        '🇸🇴' => 'SO',
        '🇬🇾' => 'GY',
        '🇵🇾' => 'PY',
        '🇹🇯' => 'TJ',
        '🇮🇳' => 'IN',
        '🇲🇲' => 'MM',
        '🇶🇦' => 'QA',
        '🇫🇲' => 'FM',
        '🇭🇳' => 'HN',
        '🇪🇷' => 'ER',
        '🇸🇬' => 'SG',
        '🇳🇪' => 'NE',
        '🇭🇺' => 'HU',
        '🇲🇫' => 'MF',
        '🇳🇷' => 'NR',
        '🇲🇪' => 'ME',
        '🇿🇼' => 'ZW',
        '🇭🇰' => 'HK',
        '🇫🇯' => 'FJ',
        '🇧🇸' => 'BS',
        '🇧🇴' => 'BO',
        '🇨🇭' => 'CH',
        '🇸🇿' => 'SZ',
        '🇻🇦' => 'VA',
        '🇸🇳' => 'SN',
        '🇺🇦' => 'UA',
        '🇹🇨' => 'TC',
        '🇨🇻' => 'CV',
        '🇧🇱' => 'BL',
        '🇦🇫' => 'AF',
        '🇧🇬' => 'BG',
        '🇸🇸' => 'SS',
        '🇸🇭' => 'SH',
        '🇵🇳' => 'PN',
        '🇨🇺' => 'CU',
        '🇱🇾' => 'LY',
        '🇯🇵' => 'JP',
        '🇹🇹' => 'TT',
        '🇮🇲' => 'IM',
        '🇯🇪' => 'JE',
        '🇵🇼' => 'PW',
        '🇸🇯' => 'SJ',
        '🇲🇬' => 'MG',
        '🇳🇱' => 'NL',
        '🇬🇸' => 'GS',
        '🇦🇪' => 'AE',
        '🇨🇫' => 'CF',
        '🇸🇰' => 'SK',
        '🇩🇴' => 'DO',
        '🇲🇽' => 'MX',
        '🇵🇫' => 'PF',
        '🇩🇯' => 'DJ',
        '🇲🇿' => 'MZ',
        '🇯🇴' => 'JO',
        '🇪🇹' => 'ET',
        '🇬🇬' => 'GG',
        '🇧🇩' => 'BD',
        '🇵🇱' => 'PL',
        '🇩🇪' => 'DE',
        '🇱🇷' => 'LR',
        '🇬🇲' => 'GM',
        '🇬🇧' => 'GB',
        '🇱🇻' => 'LV',
        '🇪🇸' => 'ES',
        '🇩🇿' => 'DZ',
        '🇧🇾' => 'BY',
        '🇫🇮' => 'FI',
        '🇦🇿' => 'AZ',
        '🇬🇵' => 'GP',
        '🇻🇪' => 'VE',
        '🇹🇫' => 'TF',
        '🇬🇦' => 'GA',
        '🇹🇬' => 'TG',
        '🇦🇸' => 'AS',
        '🇻🇮' => 'VI',
        '🇱🇰' => 'LK',
        '🇦🇹' => 'AT',
        '🇰🇷' => 'KR',
        '🇬🇹' => 'GT',
        '🇮🇱' => 'IL',
        '🇼🇸' => 'WS',
        '🇲🇸' => 'MS',
        '🇲🇵' => 'MP',
        '🇨🇨' => 'CC',
        '🇹🇳' => 'TN',
        '🇱🇸' => 'LS',
        '🇷🇸' => 'RS',
        '🇰🇾' => 'KY',
        '🇧🇿' => 'BZ',
        '🇨🇾' => 'CY',
        '🇬🇱' => 'GL',
        '🇷🇴' => 'RO',
        '🇭🇹' => 'HT',
        '🇬🇩' => 'GD',
        '🇲🇼' => 'MW',
        '🇵🇹' => 'PT',
        '🇨🇼' => 'CW',
        '🇧🇷' => 'BR',
        '🇹🇭' => 'TH',
        '🇲🇱' => 'ML',
        '🇹🇱' => 'TL',
        '🇪🇨' => 'EC',
        '🇲🇳' => 'MN',
        '🇧🇲' => 'BM',
        '🇦🇺' => 'AU',
        '🇮🇴' => 'IO',
        '🇫🇰' => 'FK',
        '🇼🇫' => 'WF',
        '🇸🇲' => 'SM',
        '🇮🇸' => 'IS',
        '🇦🇴' => 'AO',
        '🇬🇷' => 'GR',
        '🇱🇹' => 'LT',
        '🇵🇲' => 'PM',
        '🇬🇮' => 'GI',
        '🇵🇬' => 'PG',
        '🇺🇿' => 'UZ',
        '🇹🇲' => 'TM',
        '🇸🇽' => 'SX',
        '🇾🇪' => 'YE',
        '🇳🇬' => 'NG',
        '🇸🇱' => 'SL',
        '🇧🇼' => 'BW',
        '🇬🇪' => 'GE',
        '🇧🇯' => 'BJ',
        '🇦🇽' => 'AX',
        '🇨🇮' => 'CI',
        '🇪🇭' => 'EH',
        '🇰🇵' => 'KP',
        '🇲🇴' => 'MO',
        '🇨🇴' => 'CO',
        '🇸🇹' => 'ST',
        '🇪🇪' => 'EE',
        '🇾🇹' => 'YT',
        '🇲🇶' => 'MQ',
        '🇹🇿' => 'TZ',
        '🇩🇲' => 'DM',
        '🇯🇲' => 'JM',
        '🇸🇮' => 'SI',
        '🇿🇦' => 'ZA',
        '🇬🇶' => 'GQ',
        '🇬🇳' => 'GN',
        '🇺🇬' => 'UG',
        '🇰🇭' => 'KH',
        '🇸🇻' => 'SV',
        '🇧🇪' => 'BE',
        '🇻🇬' => 'VG',
        '🇺🇸' => 'US',
        '🇰🇲' => 'KM',
        '🇫🇴' => 'FO',
        '🇧🇶' => 'BQ',
        '🇨🇷' => 'CR',
        '🇳🇫' => 'NF',
        '🇰🇪' => 'KE',
        '🇻🇺' => 'VU',
        '🇸🇷' => 'SR',
        '🇲🇩' => 'MD',
        '🇬🇭' => 'GH',
        '🇲🇻' => 'MV',
        '🇪🇬' => 'EG',
        '🇮🇪' => 'IE',
        '🇽🇰' => 'XK',
        '🇨🇱' => 'CL',
        '🇰🇮' => 'KI',
        '🇲🇨' => 'MC',
        '🇮🇶' => 'IQ',
        '🇧🇫' => 'BF',
        '🇳🇵' => 'NP',
        '🇴🇲' => 'OM',
        '🇰🇼' => 'KW',
        '🇵🇭' => 'PH',
        '🇰🇳' => 'KN',
        '🇰🇬' => 'KG',
        '🇲🇺' => 'MU',
        '🇨🇽' => 'CX',
        '🇧🇻' => 'BV',
        '🇺🇾' => 'UY',
        '🇮🇷' => 'IR',
        '🇱🇧' => 'LB',
        '🇹🇻' => 'TV',
        '🇰🇿' => 'KZ',
        '🇨🇰' => 'CK',
        '🇲🇾' => 'MY',
        '🇺🇲' => 'UM',
        '🇫🇷' => 'FR',
        '🇻🇨' => 'VC',
        '🇳🇺' => 'NU',
        '🇱🇦' => 'LA',
        '🇲🇹' => 'MT',
        '🇨🇩' => 'CD',
        '🇦🇼' => 'AW',
        '🇵🇦' => 'PA',
        '🇹🇩' => 'TD',
        '🇸🇪' => 'SE',
        '🇮🇩' => 'ID',
        '🇳🇴' => 'NO',
        '🇱🇨' => 'LC',
        '🇹🇰' => 'TK',
        '🇦🇬' => 'AG',
        '🇱🇮' => 'LI',
        '🇸🇨' => 'SC',
        '🇳🇦' => 'NA',
        '🇷🇪' => 'RE',
        '🇧🇭' => 'BH',
        '🇬🇫' => 'GF',
        '🇦🇷' => 'AR',
        '🇲🇦' => 'MA',
        '🇹🇼' => 'TW',
        '🇹🇴' => 'TO',
        '🇧🇦' => 'BA',
        '🇦🇩' => 'AD',
        '🇵🇰' => 'PK',
        '🇿🇲' => 'ZM',
        '🇬🇼' => 'GW',
        '🇬🇺' => 'GU',
        '🇸🇦' => 'SA',
        '🇨🇿' => 'CZ',
        '🇦🇲' => 'AM',
        '🇻🇳' => 'VN',
        '🇦🇱' => 'AL',
        '🇵🇪' => 'PE',
        '🇸🇩' => 'SD',
        '🇸🇧' => 'SB',
        '🇨🇲' => 'CM',
        '🇱🇺' => 'LU',
        '🇦🇮' => 'AI',
        '🇲🇭' => 'MH',
        '🇲🇰' => 'MK',
        '🇧🇹' => 'BT',
        '🇧🇮' => 'BI',
        '🇳🇿' => 'NZ'
    ];

    public function getCountries(): \Illuminate\Http\JsonResponse
    {
        $countriesJson = file_get_contents(public_path('data/countries.json'));

        $countries = json_decode($countriesJson, true);

        foreach ($countries as &$country) {
            $flag = $country['flag'];
            if (array_key_exists($flag, $this->emojiToCode)) {
                $country['flag'] = $this->emojiToCode[$flag];
            } else {
                $country['flag'] = 'BN';
            }
        }

        return response()->json($countries);
    }

    public function registerUser(Request $request): string
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

            // Send email and SMS to the user (implementation not provided here)
            Mail::to($request->email)->send(new RegistrationConfirmation($user));
            $message = "Congratulation! Your registration confirmed!";


            $account_sid ="ACa600d87e517168502c90908bdb0254a0";
            $auth_token = "f64b72b5192f80553387ed64208d15ca";
            $twilio_number = "+15169906171";

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $request->phoneNumber,
                array(
                    'from' => $twilio_number,
                    'body' => $message
                )
            );


            // Return a success message
            return 'OK';
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction and return an error message
            DB::rollBack();
            return 'Error here: ' . $e->getMessage();
        }
    }

    public function getAllUsers()
    {
        return User::with(['userCountry', 'phoneBook'])->get();
    }

}
