<?php

namespace App\Http\Controllers;

use App\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Validator;

class DonationController extends Controller
{
    public function addDonation(Request $request)
    {
        //request for all post values
        $input = $request->all();

        //Validate to ensure valid inputs
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'currency' => [
                'size:3',
                Rule::in(['SEK','EUR','DKK','NOK','GBP','USD','PLN','HRK'])
            ],
            'amount' => 'required|numeric',
        ]);

        //handle validation error
        if ($validator->fails()) {
            $errorMessage = "";
            foreach ($validator->errors()->all() as $err) {
                $errorMessage .= $err . "\n";
            }
            
            return $this->sendError('Validation Error.', $errorMessage, 422);
        }

        $donation = new Donation();
        $donationRef = $donation->generateDonationRef();
        $donation->donation_ref = $donationRef;
        $donation->name = ucwords($input['name']);
        $donation->email = strtolower($input['email']);
        $donation->phone = $input['phone'];
        if (isset($input['currency'])) $donation->currency = $input['currency'];
        $donation->amount = $input['amount'];
        $donation->ip = $request->ip();
        $donation->save();

        $success_url = env('APP_URL') . '/success'; $callback_url = 'http://test.rad5.com.ng/callback/'; // env('APP_URL') . '/callback';
        $back_url = env('APP_URL'); $failed_url = env('APP_URL') . '/failed';
        $error_url = env('APP_URL') . '/error'; $currency = isset($input['currency']) ? $input['currency'] : 'USD';

        $string = $input['amount'] . $back_url . $callback_url . $currency . $error_url . $failed_url . env('GATEWAY_MERCHANT') . $donationRef . $success_url . $donation->id . env('GATEWAY_SECRET');
        $string_nospace = str_replace(' ', '', $string);
        $mac_string = hash('sha256', $string_nospace);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('GATEWAY_URL'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        // curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer ' . env('GATEWAY_SECRET')));

        $payload = [
            'merchant_key' => env('GATEWAY_MERCHANT'),
            'order_id' => $donationRef,
            'amount' => $input['amount'],
            'currency' => $currency,
            'success_url' => $success_url,
            'callback_url' => $callback_url,
            'back_url' => $back_url,
            'failed_url' => $failed_url,
            'error_url' => $error_url,
            'user_id' => $donation->id,
            'redirect_type' => 3,
            'email' => strtolower($input['email']),
            'phone' => $input['phone'],
            'mac_string' => $mac_string
        ];

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 

        return response($response, 200);
    }

    public function viewDonations(Request $request)
    {
        $allDonations = Donation::all();

        foreach ($allDonations as $donation) {
            $donation->transaction;
        }

        return $this->sendResponse($allDonations->toArray(), 'Donations retrieved');
    }
}
