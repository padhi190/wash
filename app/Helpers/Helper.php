<?php

namespace App\Helpers;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;

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
        // $survey_link = 'http://shorturl.at/fvwDZ';
        $survey_link = route('survey.create', ['branch_id' => $branch->id, 'income_id' => $income->id]);
        
        $message = "*Wash, Inc ". $branch->branch_name . '*'. PHP_EOL .
                    'Total : Rp ' . number_format($income->total_amount) .' (' . $income->vehicle->license_plate . ')' .PHP_EOL .
                    $branch->address . ', ' . $branch->city . PHP_EOL . PHP_EOL .
                    'Berikan ulasan anda & dapatkan harga khusus Spray Wax ~Rp 85,000~ Rp 70,000 ' . PHP_EOL . $survey_link . PHP_EOL . 
                    '(Save kontak ini agar link dapat di klik)' ;
        // $phone = $income->vehicle->customer->phone;
        $phone = '081322999456';
        $custom_uid = $income->nobon;
        self::sendWA($url, $phone, $message, $custom_uid);
        
        
    }

    public static function sendVOUCHER(\App\Income $income, $branch)
    {
    	$valid = $income->created_at;
    	$valid->addDays(14);
        $branch = \App\Branch::findOrFail(session('branch_id'));
        $url = $branch->sms_url;
        $voucher= self::generateRandomString();
        $message='Terima Kasih atas feedback Anda. Anda mendapatkan harga khusus Carwash + Spray Wax for ~Rp 65,000~  Rp 50,000 di Wash, Inc ' . $income->branch->branch_name .'. *Kode voucher: ' . $voucher .'* berlaku s.d. *' . $valid->format("j M 'y"). '*. Info: ' . $income->branch->phone;
        $phone = $income->vehicle->customer->phone;
        $custom_uid = $income->nobon . Carbon::now();
        self::sendWA($url, $phone, $message, $custom_uid);
        // $phone = self::convert_phone($phone);


        // if($phone != '')
        // {
        //     $client = new \GuzzleHttp\Client();
            
        //     $response = $client->put($url, [
        //         'query' => ['token' => '364c2bb8ec26bda46614d82f6b76bc6f5de1c9205d92d',
        //                     'uid' => '6282116273608',
        //                     'to' => $phone,
        //                     'custom_uid' => $income->nobon,
        //                     'text'=> $message],
        //         'future' => true
        //     ]);

        //     $response->then(function ($response) {
        //         console.log($response);
        //     });

        // }
        
    }


    public static function checkWAStatus($phone)
    {
        $uid = self::convert_phone($phone);
        $url = 'https://www.waboxapp.com/api/status/'.$uid;
        if($phone != '')
        {
            $client = new \GuzzleHttp\Client();
            
            try {
                $response = $client->put($url, [
                    'query' => ['token' => '364c2bb8ec26bda46614d82f6b76bc6f5de1c9205d92d'],
                ]);
                if($response->getStatusCode() == "200")
                    return $response->json();
            } catch (RequestException $e) {
                 return ['success' => false];
            }

        }


    }

    public static function sendExpenseWarning($expense, $branch)
    {
        $message = $expense->expense_category->name . " Rp " . number_format($expense->amount) . PHP_EOL . $expense->signature . PHP_EOL .
                    $expense->note . PHP_EOL . "at Wash, Inc " . $branch->branch_name;
        $url = $branch->sms_url;

        if($branch->branch_name == "Kopo")
        {
            $phones = ['081322999456', '08122363622'];
        }
        elseif ($branch->branch_name = "Buah Batu") {
            $phones = ['081322999456'];   
        }
        else
        {
            $phones = ['081322999456', '08122363622'];
        }

        foreach ($phones as $phone) {
            $custom_uid = $expense->id . $branch->branch_name . $phone;
            self::sendWA($url, $phone, $message, $custom_uid);
        }
        
    }

    public static function sendWA($url, $phone, $message, $custom_uid)
    {
        $phone = self::convert_phone($phone);


        if($phone != '')
        {
            $client = new \GuzzleHttp\Client();
            
            $response = $client->put($url, [
                'query' => ['token' => '364c2bb8ec26bda46614d82f6b76bc6f5de1c9205d92d',
                            'uid' => '6282116273608',
                            'to' => $phone,
                            'custom_uid' => $custom_uid,
                            'text'=> $message],
                'future' => true
            ]);

            $response->then(function ($response) {
                console.log($response);
            });

        }
    }
   
}

    


	