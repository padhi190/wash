<?php

namespace App\Helpers;
use Carbon\Carbon;

class Helper
{
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
        $url = $branch->sms_url.'/SendSMS?';
        $survey_link = 'http://shorturl.at/fvwDZ';
        $message='This is your digital receipt for Rp ' . number_format($income->total_amount) . ' (' . $income->vehicle->license_plate . ') at Wash Inc ' . $income->branch->branch_name . '. Leave your feedback at ' . $survey_link;
        $phone = $income->vehicle->customer->phone;
        

        if($phone != '')
        {
            $client = new \GuzzleHttp\Client();
            $client->get($url, [
                'query' => ['username' => 'washinc',
                            'password' => 'kopo168',
                            'phone' => $phone,
                            'message'=> $message],
                'timeout'=> 3,
                'future' => true
            ]);

        }
        
    }

    public static function sendVOUCHER(\App\Income $income, $branch)
    {
    	$valid = Carbon::createFromFormat('Y-m-d H:i', $income->entry_date);
    	$valid->addDays(14);
        $branch = \App\Branch::findOrFail(session('branch_id'));
        $url = $branch->sms_url.'/SendSMS?';
        $survey_link = 'http://shorturl.at/fvwDZ';
        $voucher= self::generateRandomString();
        $message='Thank you for your feedback. Show this sms to our cashier to get our Carwash + Spray Wax for R̶p̶ ̶6̶5̶,̶0̶0̶0̶  Rp 50,000 on your next visit at Wash, Inc ' . $income->branch->branch_name .'. Voucher code: ' . $voucher .' valid until ' . $valid->format("j M 'y") . '. More info: ' . $income->branch->phone;
        $phone = $income->vehicle->customer->phone;
        


        if($phone != '')
        {
            $client = new \GuzzleHttp\Client();
            $client->get($url, [
                'query' => ['username' => 'washinc',
                            'password' => 'kopo168',
                            'phone' => $phone,
                            'message'=> $message],
                'timeout'=> 3,
                'future' => true
            ]);

        }
        
    }
   
}

    


	