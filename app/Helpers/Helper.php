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
        $branch = \App\Branch::find($branch->id);
        $url = $branch->sms_url;
        // $survey_link = 'http://shorturl.at/fvwDZ';
        $survey_link = route('survey.create', ['branch_id' => $branch->id, 'income_id' => base_convert($income->id,10, 16)]);
        
        $message = "*Wash, Inc ". $branch->branch_name . '*'. PHP_EOL .
                    'Total : Rp ' . number_format($income->total_amount) .' (' . $income->vehicle->license_plate . ')' .PHP_EOL .
                    $branch->address . ', ' . $branch->city . PHP_EOL . PHP_EOL;

        $promo = self::getPromoType($income);
        // dd($promo);
        if($promo['giveVoucher'])
        {
            $promo_message = 'Berikan ulasan anda & dapatkan harga khusus ' . $promo['voucherType'] . ' ~' . $promo['hargaCoret'] . '~ ' . $promo['hargaDiskon'] . PHP_EOL . $survey_link . PHP_EOL . '(Save kontak ini agar link dapat di klik)';
        }
        else
        {
            $promo_message   =  'Berikan ulasan anda disini' . PHP_EOL . $survey_link . PHP_EOL . 
                    '(Save kontak ini agar link dapat di klik)' ;
        }
        

        $message .= $promo_message;
        // $phone = $income->vehicle->customer->phone;
        $phone = '081322999456';
        $custom_uid = $income->nobon;
        self::sendWA($url, $phone, $message, $custom_uid);
        
        
    }

    public static function sendVOUCHER(\App\Survey $survey, $branch)
    {
        $message = 'Terima Kasih atas feedback Anda.' . PHP_EOL . 'Wash, Inc. ' . $branch->branch_name;
        $income = $survey->income;
        $promo = self::getPromoType($income);

        if($promo['giveVoucher'])
        {
            $valid = Carbon::parse($survey->expiry_date);
            $message='Terima Kasih atas feedback Anda.'. PHP_EOL. 'Anda mendapatkan harga khusus ' .$survey->coupon_type . ' ~' . $promo['hargaCoret'] . '~ ' . $promo['hargaDiskon'] . ' di Wash, Inc ' . $income->branch->branch_name . PHP_EOL .'*Kode voucher: ' . $survey->coupon_code .'*'. PHP_EOL. 'berlaku s.d. *' . $valid->format("j M 'y"). '*'.PHP_EOL .'Info: ' . $income->branch->phone;

        }
    	
        
    	
        $url = $branch->sms_url;
        

        
        // $phone = $income->vehicle->customer->phone;
        $phone = '081322999456';
        $custom_uid = $income->nobon . Carbon::now();
        self::sendWA($url, $phone, $message, $custom_uid);
        
        
    }

    public static function getPromoType(\App\Income $income)
    {
        
        $promo['giveVoucher'] = false;
        
        // Carwash
        if ($income->income_category_id == 1) 
        {
            // dd($income->wax_type);
            $promo['giveVoucher'] = true;
            switch ($income->wax_type) {
                case 'None':
                    $promo['voucherType'] = 'Spray Wax';
                    $promo['hargaCoret'] = 'Rp 100.000';
                    $promo['hargaDiskon'] = 'Rp 70.000';
                    $promo['expire'] = 14;
                    break;

                case 'Spray':
                    $promo['voucherType'] = 'Cream Wax';
                    $promo['hargaCoret'] = 'Rp 125.000';
                    $promo['hargaDiskon'] = 'Rp 90.000';
                    $promo['expire'] = 14;
                    break;

                case 'Cream':
                    $promo['voucherType'] = 'Soft Coating';
                    $promo['hargaCoret'] = 'Rp 350.000';
                    $promo['hargaDiskon'] = 'Rp 225.000';
                    $promo['expire'] = 14;
                    break;

                case 'Softcoat':
                    $promo['voucherType'] = 'Detailing';
                    $promo['hargaCoret'] = '5%';
                    $promo['hargaDiskon'] = '10%';
                    $promo['expire'] = 31;
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        // Detailing
        elseif ($income->income_category_id == 3) {
            # code...
            $promo['giveVoucher'] = true;
            $promo['voucherType'] = 'Car Wash';
            $promo['hargaCoret'] = 'Rp 50.000';
            $promo['hargaDiskon'] = 'Free';
            $promo['expire'] = 14;
        }

        return $promo;
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

    


	