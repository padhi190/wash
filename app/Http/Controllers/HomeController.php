<?php

namespace App\Http\Controllers;

use DB;
use App\Income;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        if (! Gate::allows('dashboard_access')) 
        {
            return redirect('incomes/create');
        }
        $now = Carbon::parse(sprintf('%s',$r->query('req_date', Carbon::today())));
        // var_dump($now);
        $today = clone $now;
        $now->hour=23;
        $now->minute=59;
        $today_sales_no = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->where('branch_id', session('branch_id'))
                        // ->distinct('vehicle_id')
                        ->count('vehicle_id');

        $today_sales_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->where('branch_id', session('branch_id'))
                        // ->sum('amount');
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $today_sales_debit = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->where('branch_id', session('branch_id'))
                        ->where('payment_type_id', '!=', 1)
                        // ->sum('amount');
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $today_sales_dollar_mobil = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','mobil')
                        ->where('branch_id', session('branch_id'))
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $today_sales_dollar_motor = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','motor')
                        ->where('branch_id', session('branch_id'))
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $today_sales_no_mobil = Income::with('income_category')
                        // ->distinct('vehicle_id')
                        ->whereBetween('entry_date', [$today, $now])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','mobil')
                        ->where('branch_id', session('branch_id'))
                        ->count('vehicle_id');

        $today_sales_no_motor = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','motor')
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $today_sales_detailing = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->where('income_category_id', 3)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $today_sales_no_detailing = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->where('income_category_id', 3)
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $today_sales_fnb = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->where('fnb_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('fnb_amount');

        $today_no_fnb_mobil = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('fnb_amount', '>', '0')
                        ->where('type', 'mobil')
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $today_no_fnb_motor = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $now])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('fnb_amount', '>', '0')
                        ->where('type', 'motor')
                        ->where('branch_id', session('branch_id'))
                        ->count();



        // dd($today_sales_dollar);
        // Get Last x Days Data
        $sub_days = 13;
        $last_week = $today->subDays($sub_days);

        $date=[];
        $sales_dollar=[];
        $sales_no=[];

        $carwash_no=[];
        $carwash_dollar=[];
        $bikewash_no=[];
        $bikewash_dollar=[];

        $wax_no=[];
        $wax_dollar=[];
        $i=0;
        $from = new Carbon;
        $to = new Carbon;
        $from = clone $last_week;
        $to = clone $last_week;

        // cut off date from old format to new format:
        $new_format = Carbon::parse('2017-11-30 23:59:59'); 
        
        while ($to < $now) {
            $date[$i] = $from->format('D, j-M');
            $sales_no[$i] = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to->addHours(23)->addMinutes(59)])
                        ->where('branch_id', session('branch_id'))
                        ->count();

            $sales_dollar[$i] = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

            // $carwash_no[$i] 
            $carwash_no_temp1 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','mobil')
                        ->where('income_category_id', 1)
                        ->where('branch_id', session('branch_id'))
                        ->count();

            $carwash_no_temp2 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','mobil')
                        ->where('income_category_id',1)
                        ->where('branch_id', session('branch_id'))
                        ->count();

            $bikewash_no_temp1 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','motor')
                        ->whereIn('income_category_id', [1,5])
                        ->where('branch_id', session('branch_id'))
                        ->count();

            $bikewash_no_temp2 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('type','motor')
                        ->where('income_category_id', 5)
                        ->where('branch_id', session('branch_id'))
                        ->count();


            // $carwash_dollar[$i] 

            $carwash_dollar_temp1 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [1])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

            $carwash_dollar_temp2 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [1])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

            // $bikewash_dollar[$i]

            $bikewash_dollar_temp1 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [5])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

            $bikewash_dollar_temp2 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [5])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

            // $wax_no[$i] 

            $wax_no_temp1 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 2)
                        ->where('branch_id', session('branch_id'))
                        ->count();

            $wax_no_temp2 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->count();

            // $wax_dollar[$i] 

            $wax_dollar_temp1 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 2)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

            $wax_dollar_temp2 = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('wax_amount');

            if($from < $new_format) {
                // use old format
                $carwash_no[$i]         = $carwash_no_temp1;
                $carwash_dollar[$i]     = $carwash_dollar_temp1;
                $bikewash_dollar[$i]    = $bikewash_dollar_temp1;
                $wax_no[$i]             = $wax_no_temp1;
                $wax_dollar[$i]         = $wax_dollar_temp1;
                $bikewash_no[$i]        = $bikewash_no_temp1;

            } else {
                // use new format
                $carwash_no[$i]         = $carwash_no_temp2;
                $carwash_dollar[$i]     = $carwash_dollar_temp2;
                $bikewash_dollar[$i]    = $bikewash_dollar_temp2;
                $wax_no[$i]             = $wax_no_temp2;
                $wax_dollar[$i]         = $wax_dollar_temp2;
                $bikewash_no[$i]        = $bikewash_no_temp2;
            }


            // var_dump($from->toDayDateTimeString());
            // var_dump($to->toDayDateTimeString());
            // var_dump($carwash_no[$i]);
            $from->addDays(1);
            $to->addMinutes(1);
            $i+=1;   
        }

        // Get intraday sales data
        $today->addDays($sub_days);
        $today->hour=7;
        $now->hour=21;
        $now->minute=0;
        $intra_to = clone $today;
        $intra_to->addHours(1);
        $hour=[];
        $intra_sales_no=[];
        $intra_wax_no=[];

        $i=0;
        while($today < $now) {
            $hour[$i]=$today->format('H:i');
            $intra_sales_no[$i] = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $intra_to])
                        ->where('branch_id', session('branch_id'))
                        ->count();

            // $intra_wax_no[$i] = Income::with('income_category')
            //             ->whereBetween('entry_date', [$today, $intra_to])
            //             ->where('income_category_id', 2)
            //             ->where('branch_id', session('branch_id'))
            //             ->count();

            $intra_wax_no[$i] = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $intra_to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->count();

            $today->addHours(1);
            $intra_to->addHours(1);
            $i+=1;
        }

        // Get weekly sales
        $today->hour=0;

        $week_lookback=4;
        $days_lookback= $week_lookback * 7 + $now->dayOfWeek-1;
        $today->subDays($days_lookback);
        
        $week_date=[];
        $weekly_sales_no=[];
        $weekly_wax_no=[];
        $i=0;

        $to = clone $today;
        while ($today < $now) {
            $to->addDays(7);
            $week_date[$i] = $today->format('D, j-M');
            $weekly_sales_no[$i] = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $to])
                        ->where('branch_id', session('branch_id'))
                        ->count();

            // $weekly_wax_no[$i] = Income::with('income_category')
            //             ->whereBetween('entry_date', [$today, $to])
            //             ->where('income_category_id', 2)
            //             ->where('branch_id', session('branch_id'))
            //             ->count();

            $weekly_wax_no[$i] = Income::with('income_category')
                        ->whereBetween('entry_date', [$today, $to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->count();


            $today->addDays(7);
            $i+=1;
        }

        // dd($weekly_wax_no);

        $now_date = $now->toDateString();
        $data = [65, 59, 80, 81, 56, 55, 100];
        // dd($today_sales_dollar);
        return view('home', compact( 
                            'today_sales_no',
                            'today_sales_no_mobil',
                            'today_sales_no_motor', 
                            'today_sales_dollar',
                            'today_sales_debit', 
                            'today_sales_dollar_mobil',
                            'today_sales_dollar_motor',
                            'now_date', 
                            'date', 
                            'sales_dollar', 
                            'sales_no',
                            'carwash_no',
                            'carwash_dollar',
                            'bikewash_dollar', 
                            'wax_no',
                            'wax_dollar',
                            'intra_sales_no',
                            'intra_wax_no',
                            'hour',
                            'week_date',
                            'weekly_wax_no',
                            'weekly_sales_no',
                            'bikewash_no',
                            'today_sales_detailing',
                            'today_sales_no_detailing',
                            'today_sales_fnb',
                            'today_no_fnb_motor',
                            'today_no_fnb_mobil'
                            ));
    }

}
