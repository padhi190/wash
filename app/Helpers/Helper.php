<?php

namespace App\Helpers;
use Carbon\Carbon;

class Helper
{
    public static function convert_phone($phone)
    {
        //make sure the phone is actually a phone
        if(is_numeric($phone)){

            //if phone starts with a 0 replace with 6
            if($phone[0] == 0){
                // trim leading zeros
                $trim = ltrim($phone,"0");
                $phone = '62'.$trim;
                
            }

            //remove any spaces in the phone
            $phone = str_replace(" ","",$phone);

            //return the phone
            return $phone;
        }
        else{
            return false;
        }
    }

	public static function generateRandomString($length = 5) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

	public static function sendBON(\App\Income $income, $branch)
    {
        $branch = \App\Branch::findOrFail(session('branch_id'));
        $url = $branch->sms_url;
        $survey_link = 'http://shorturl.at/fvwDZ';
        $message='This is your digital receipt for Rp ' . number_format($income->total_amount) . ' (' . $income->vehicle->license_plate . ') at Wash Inc ' . $income->branch->branch_name . '. Leave your feedback at ' . $survey_link;
        $phone = $income->vehicle->customer->phone;
        $phone = self::convert_phone($phone);


        if($phone != '')
        {
            $client = new \GuzzleHttp\Client();
            
            $response = $client->put($url, [
                'query' => ['token' => '364c2bb8ec26bda46614d82f6b76bc6f5de1c9205d92d',
                            'uid' => '6281322999456',
                            'to' => $phone,
                            'custom_uid' => $income->nobon,
                            'text'=> $message],
                'future' => true
            ]);

            $response->then(function ($response) {
                console.log($response);
            });

        }
        
    }

    public static function sendVOUCHER(\App\Income $income, $branch)
    {
    	$valid = $income->created_at;
    	$valid->addDays(14);
        $branch = \App\Branch::findOrFail(session('branch_id'));
        $url = $branch->sms_url;
        $voucher= self::generateRandomString();
        $message='Thank you for your feedback. Show this sms to our cashier to get our Carwash + Spray Wax for ~Rp 65,000~  Rp 50,000 on your next visit at Wash, Inc ' . $income->branch->branch_name .'. *Voucher code: ' . $voucher .'* valid until *' . $valid->format("j M 'y"). '*. More info: ' . $income->branch->phone;
        $phone = $income->vehicle->customer->phone;
        $phone = self::convert_phone($phone);


        if($phone != '')
        {
            $client = new \GuzzleHttp\Client();
            
            $response = $client->put($url, [
                'query' => ['token' => '364c2bb8ec26bda46614d82f6b76bc6f5de1c9205d92d',
                            'uid' => '6281322999456',
                            'to' => $phone,
                            'custom_uid' => $income->nobon,
                            'text'=> $message],
                'future' => true
            ]);

            $response->then(function ($response) {
                console.log($response);
            });

        }
        
    }
   
}

    


	