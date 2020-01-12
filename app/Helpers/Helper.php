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
        
        $message = "_(Hi Gaes, ini pesan otomatis dari Wash, Inc jadi gawsa dibales cukup dibaca lalu klik link ajah)_" . PHP_EOL . "*Wash, Inc ". $branch->branch_name . '*'. PHP_EOL .
                    'Total : Rp ' . number_format($income->total_amount) .' (' . $income->vehicle->license_plate . ')' .PHP_EOL .
                    $branch->address . ', ' . $branch->city . PHP_EOL . PHP_EOL;

        $promo = self::getPromoType($income, $branch);
        // dd($promo);
        if($promo['giveVoucher'] == 'surveyVoucher')
        {
            $promo_message = 'Berikan ulasan Anda & dapatkan harga khusus ' . $promo['voucherType'] . ' ~' . $promo['hargaCoret'] . '~ ' . $promo['hargaDiskon'] . PHP_EOL . $survey_link . PHP_EOL . '(Save kontak ini agar link dapat di klik)';
        }
        elseif($promo['giveVoucher'] == 'direct')
        {
            $voucher_code = self::generateRandomString();
            $expiry = Carbon::now()->addDays($promo['expire'])->format("j M 'y");
            $promo_message = 'Kamu dapet potongan nih Gaes buat *' . $promo['voucherType'] . "* di Wash, Inc " . $branch->branch_name . "." . PHP_EOL .
                             '✅ Harga Spesial khusus buat kamu niiih ya *~' . $promo['hargaCoret'] . '~ ' . $promo['hargaDiskon'] . '*' . PHP_EOL .
                             '✅ *Kode Voucher: ' . $voucher_code . '*' . PHP_EOL .
                             '✅ Tukerin nih voucher *sebelum ' . $expiry . '* di Wash, Inc ' . $branch->branch_name . "." . PHP_EOL  .
                             'Jan lupa loh!' . PHP_EOL .
                             'Info: ' . $branch->phone . PHP_EOL . PHP_EOL .
                             'Tengkyuuu bet ya Gaes udah jadi pelanggan setia Wash, Inc 🥰. Jan lupa kasi pesan yang berkesan dengan nge-klik link dibawah ini ' . $survey_link . ' 😘' ;
        }
        else
        {
            $promo_message   =  'Tengkyuuu bet ya Gaes udah jadi pelanggan setia Wash, Inc 🥰. Jan lupa kasi pesan yang berkesan dengan nge-klik link dibawah ini ' . PHP_EOL . $survey_link . PHP_EOL . 
                    '(Save dulu nomer ini yaa biar link nya bisa di klik 😘)' ;
        }
        

        $message .= $promo_message;
        $phone = $income->vehicle->customer->phone;
        // $phone = '081322999456';
        // dd($message);
        $custom_uid = $income->nobon;
        self::sendWA($url, $phone, $message, $custom_uid);
        
        
    }

    public static function sendVOUCHER(\App\Survey $survey, $branch)
    {
        $message = 'Bhaiiqqq... Tengkyu banget lho yaaa udah kasi pesan yang berkesan 🤗' . PHP_EOL . 
                    'Wash, Inc. ' . $branch->branch_name . PHP_EOL . 
                    $branch->address . ', ' . $branch->city . PHP_EOL . 
                    $branch->phone . PHP_EOL .
                    '_(Pesan otomatis dari Wash, Inc)_';
        $income = $survey->income;
        $promo = self::getPromoType($income, $branch);

        if($promo['giveVoucher'] == 'surveyVoucher')
        {
            $valid = Carbon::parse($survey->expiry_date);


            $message='Terima Kasih sudah mengisi survey dan membantu kami menjadi lebih baik.'. PHP_EOL. 'Sebagai tanda terima kasih, kami memberikan potongan harga khusus ' .$survey->coupon_type . ' untuk Anda.'. PHP_EOL . 'Harga Khusus ~' . $promo['hargaCoret'] . '~ ' . $promo['hargaDiskon'] . ' di Wash, Inc ' . $income->branch->branch_name . PHP_EOL .'*Kode voucher: ' . $survey->coupon_code .'*'. PHP_EOL. 'berlaku s.d. *' . $valid->format("j M 'y"). '*'.PHP_EOL .'Info: ' . $income->branch->phone;
            if($survey->coupon_type == 'Detailing')
            {
                $message='Terima Kasih sudah mengisi survey dan membantu kami menjadi lebih baik.'. PHP_EOL. 'Sebagai tanda terima kasih, kami memberikan voucher Potongan Khusus Detailing untuk Anda di Wash, Inc ' . $income->branch->branch_name . ' sebesar '. $promo['hargaDiskon'] . ' dari harga normal. '. PHP_EOL . 'Gunakan Voucher ini agar mobil anda menjadi kembali berkilau seperti ketika masih baru :)' .PHP_EOL .'*Kode voucher: ' . $survey->coupon_code .'*'. PHP_EOL. 'berlaku s.d. *' . $valid->format("j M 'y"). '*'.PHP_EOL .'Info: ' . $income->branch->phone;                
            }

        }
    	
        
    	
        $url = $branch->sms_url;
        

        
        $phone = $income->vehicle->customer->phone;
        // $phone = '081322999456';
        $custom_uid = $income->nobon . Carbon::now();
        self::sendWA($url, $phone, $message, $custom_uid);
        
        
    }

    public static function getPromoType(\App\Income $income, $branch)
    {
        
        $promo['giveVoucher'] = 'none';
        $prices = config('pricelist'.$branch->id);
        // Carwash
        if ($income->income_category_id == 1) 
        {
            // dd($income->wax_type);
            $promo['giveVoucher'] = 'direct';
            switch ($income->wax_type) {
                case 'None':
                    $promo['voucherType'] = 'Spray Wax';
                    $promo['hargaCoret'] = $prices['spraywax_coret'];
                    $promo['hargaDiskon'] =$prices['spraywax_promo'];
                    $promo['expire'] = 14;
                    break;

                case 'Spray':
                    $promo['voucherType'] = 'Cream Wax';
                    $promo['hargaCoret'] = $prices['creamwax_coret'];
                    $promo['hargaDiskon'] = $prices['creamwax_promo'];
                    $promo['expire'] = 14;
                    break;

                case 'Cream':
                    $promo['voucherType'] = 'Soft Coating';
                    $promo['hargaCoret'] = $prices['softcoating_coret'];
                    $promo['hargaDiskon'] = $prices['softcoating_promo'];
                    $promo['expire'] = 14;
                    break;

                case 'Softcoat':
                    $promo['voucherType'] = 'Detailing';
                    $promo['hargaCoret'] = $prices['detailing_coret'];
                    $promo['hargaDiskon'] = $prices['detailing_promo'];
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
            $promo['giveVoucher'] = 'direct';
            $promo['voucherType'] = 'Car Wash';
            $promo['hargaCoret'] = 'Rp '. number_format($prices['carwash']);
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
            $phones = ['081322999456', '08122363622', '08122440040'];
        }
        elseif ($branch->branch_name = "Buah Batu") {
            $phones = ['081322999456', '081220002211'];   
        }
        else
        {
            $phones = ['081322999456', '08122363622', '08122440040'];
        }

        foreach ($phones as $phone) {
            $custom_uid = $expense->id . $branch->branch_name . $phone;
            self::sendWA($url, $phone, $message, $custom_uid);
        }
        
    }

    public static function sendWA($url, $phone, $message, $custom_uid)
    {
        $phone = self::convert_phone($phone);
        // $phone = '6281322999456';

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

    


	