<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Branch;
use App\Income;
use Carbon\Carbon;
use DB;


class sendreport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $branches = Branch::all();
        foreach ($branches as $branch) {
            # code...
            // echo $branch->branch_name;
            $from = Carbon::now()->startOfDay();
            $to = Carbon::now()->endOfDay();

            $sales_no[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->where('branch_id', $branch->id)
                            ->count('vehicle_id');

            $sales_dollar[$branch->branch_name] = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', $branch->id)
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

            $carwash_dollar[$branch->branch_name] = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [1])
                        ->where('branch_id', $branch->id)
                        ->sum('amount');    

            $carwash_no[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->whereIn('income_category_id', [1])
                            ->where('branch_id', $branch->id)
                            ->count();

            $bikewash_dollar[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->whereIn('income_category_id', [5])
                            ->where('branch_id', $branch->id)
                            ->sum('amount');

            $bikewash_no[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->whereIn('income_category_id', [5])
                            ->where('branch_id', $branch->id)
                            ->count();

            $wax_dollar[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->where('wax_amount', '>', '0')
                            ->where('branch_id', $branch->id)
                            ->sum('wax_amount');                         
            
            $wax_no[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                            ->where('wax_amount', '>', '0')
                            ->where('branch_id', $branch->id)
                            ->count();


            $detailing_dollar[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->where('income_category_id', 3)
                            ->where('branch_id', $branch->id)
                            ->sum('amount');

            $detailing_no[$branch->branch_name] = Income::with('income_category')
                            ->whereBetween('entry_date', [$from, $to])
                            ->where('income_category_id', 3)
                            ->where('branch_id', $branch->id)
                            ->count();

            
        };
        $data = compact('sales_no', 'sales_dollar', 'carwash_dollar', 'carwash_no',
                        'bikewash_dollar', 'bikewash_no', 'wax_dollar', 'wax_no',
                        'detailing_dollar', 'detailing_no');

        $client = new \GuzzleHttp\Client();

        foreach ($branches as $branch) {
            # code...
            $branch_name = $branch->branch_name;
            $message = '*'.strtoupper($branch_name) .'*'.PHP_EOL . 'Carwash: '.$data['carwash_no'][$branch_name]. ' (Rp '. 
                    number_format($data['carwash_dollar'][$branch_name]) .')' . PHP_EOL;
            $message .= 'Bikewash: ' . $data['bikewash_no'][$branch_name]. ' (Rp ' . 
                        number_format($data['bikewash_dollar'][$branch_name]).')' .PHP_EOL .
                        'Wax: ' . $data['wax_no'][$branch_name]. ' (Rp '. 
                        number_format($data['wax_dollar'][$branch_name]) .')' . PHP_EOL .
                        'Detailing: ' . $data['detailing_no'][$branch_name]. ' (Rp '. 
                        number_format($data['detailing_dollar'][$branch_name]) .')' .PHP_EOL;

            $response = $client->put($branch->sms_url, [
            'query' => ['token' => '364c2bb8ec26bda46614d82f6b76bc6f5de1c9205d92d',
                        'uid' => '6281322999456',
                        'to' => '6281322999456',
                        'custom_uid' => $branch_name.Carbon::now(),
                        'text'=> $message],
            ]);

        }

        dd($message);
    }
}
