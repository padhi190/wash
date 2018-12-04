<?php

namespace App\Http\Controllers;

use DB;
use App\Income;
use App\Expense;
use App\Transfer;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

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

        return view('home');
    }

    public function loadDashboardData(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);
        
        $to = $enddate;
        $from = $startdate;

        $sales_no = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->count('vehicle_id');

        $sales_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $sales_debit = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->where('payment_type_id', '!=', 1)
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $used_voucher = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->where('payment_type_id', '=', 6)
                        ->count();

        $carwash_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [1])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');    

        $carwash_no = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [1])
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $bikewash_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [5])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $bikewash_no = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [5])
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $wax_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('wax_amount');                         
        
        $wax_no_mobil = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('wax_amount', '>', '0')
                        ->where('type', 'mobil')
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $wax_no_motor = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->join('vehicles', 'vehicles.id', '=', 'vehicle_id')
                        ->where('wax_amount', '>', '0')
                        ->where('type', 'motor')
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $detailing_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 3)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $detailing_no = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 3)
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $expense_dollar = Expense::where('branch_id', session('branch_id'))
                        ->whereBetween('entry_date', [$from, $to])
                        ->sum('amount');

        $expense_debit = Expense::where('branch_id', session('branch_id'))
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('from_id', '!=',1)
                        ->sum('amount');

        $fnb_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('fnb_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('fnb_amount');

        $voucher_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 6)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $etc_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 7)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $total_etc = $fnb_dollar + $voucher_dollar + $etc_dollar;


        $total_mobil = $carwash_no + $detailing_no;

        $total_motor = $bikewash_no;

        $total_vehicle = $total_mobil + $total_motor;

        return response()->json(compact('sales_no', 
                                        'sales_dollar',
                                        'sales_debit',
                                        'used_voucher',
                                        'carwash_dollar',
                                        'carwash_no',
                                        'bikewash_dollar',
                                        'bikewash_no',
                                        'wax_dollar',
                                        'wax_no_mobil',
                                        'wax_no_motor',
                                        'detailing_dollar',
                                        'detailing_no',
                                        'expense_dollar',
                                        'expense_debit',
                                        'fnb_dollar',
                                        'voucher_dollar',
                                        'etc_dollar',
                                        'total_etc',
                                        'total_motor',
                                        'total_mobil',
                                        'total_vehicle'
                                        ));
    }

    public function loadIncomeStatementData(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);
        
        $to = $enddate;
        $from = $startdate;

       
        $sales_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->sum(DB::raw('IFNULL(amount,0) + IFNULL(fnb_amount,0) + IFNULL(wax_amount,0)'));

        $carwash_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [1])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');    

        $bikewash_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [5])
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $wax_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('wax_amount');                         

        $detailing_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 3)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $expense_dollar = Expense::where('branch_id', session('branch_id'))
                        ->whereBetween('entry_date', [$from, $to])
                        ->sum('amount');

        $expenses       = Expense::where('branch_id', session('branch_id'))
                        ->select('expenses.id', 'expense_categories.parent_category', \DB::raw('sum(amount) as amount'))
                        ->join('expense_categories','expenses.expense_category_id', '=', 'expense_categories.id')
                        ->where('expense_categories.name', '!=', 'Restock Minuman/Rokok')
                        ->whereBetween('entry_date', [$from, $to])
                        ->groupby('expense_categories.parent_category')
                        ->get();

        $fnb_restock    = Expense::where('branch_id', session('branch_id'))
                        ->select('expenses.id', 'expense_categories.parent_category', \DB::raw('sum(amount) as total'))
                        ->join('expense_categories','expenses.expense_category_id', '=', 'expense_categories.id')
                        ->where('expense_categories.name', 'Restock Minuman/Rokok')
                        ->whereBetween('entry_date', [$from, $to])
                        ->groupby('expense_categories.parent_category')
                        ->get();

        $fnb_restock_total = 0;
        if(sizeof($fnb_restock))
        {
            $fnb_restock_total = $fnb_restock[0]['total'];
        }

        

        $fnb_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('fnb_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('fnb_amount');

        $fnb_profit = $fnb_dollar - $fnb_restock_total;

        $voucher_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 6)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $etc_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('income_category_id', 7)
                        ->where('branch_id', session('branch_id'))
                        ->sum('amount');

        $total_etc = $fnb_dollar + $voucher_dollar + $etc_dollar;

        $total_profit = $sales_dollar - $expense_dollar;

        return response()->json(compact('sales_dollar',
                                        'carwash_dollar',
                                        'bikewash_dollar',
                                        'wax_dollar',
                                        'detailing_dollar',
                                        'fnb_profit',
                                        'fnb_dollar',
                                        'fnb_restock_total',
                                        'voucher_dollar',
                                        'etc_dollar',
                                        'total_etc',
                                        'expense_dollar',
                                        'expenses',
                                        'total_profit'
                                        ));

    }

    public function loadIncomeDataByDate(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);

        $category = $request->input('category');

        switch ($category) {
            case 'carwash':
                $cat_id = 1;
                break;
            
            case 'bikewash':
                $cat_id = 5;
                break;

            case 'detailing':
                $cat_id = 3;
                break;

            case 'voucher':
                $cat_id = 6;
                break;

            case 'lain2':
                $cat_id = 7;
                break;

            case 'wax':
                $cat_variable = 'wax_amount';
                break;

            case 'fnb':
                $cat_variable = 'fnb_amount';
                break;

            default:
                $cat_id =[1,3,5,6,7];
                break;
        }

        $to = $enddate;
        $from = $startdate;
        if(in_array($category, ["carwash", "bikewash", "voucher", "detailing", "lain2"]))
        {
            $data = Income::select(\DB::raw('sum(amount) as amount,DATE(entry_date) as date'))
                        ->whereBetween('entry_date', [$from, $to])
                        ->whereIn('income_category_id', [$cat_id])
                        ->where('branch_id', session('branch_id'))
                        ->groupby('date')->get();
        }
        elseif($category == "total")
        {
            $data = Income::select(\DB::raw('sum(amount) as amount, sum(wax_amount) as wax_amount, sum(fnb_amount) as fnb_amount, (amount + wax_amount + fnb_amount) as total, DATE(entry_date) as date'))
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->groupby('date')->get();
        }
        else{
            $raw = 'sum(' . $cat_variable .') as amount, DATE(entry_date) as date';
          
            $data = Income::select(\DB::raw($raw))
                        ->whereBetween('entry_date', [$from, $to])
                        ->where($cat_variable, '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->groupby('date')->get();
        }

        return response()->json(compact('data'));
    }

    public function loadExpenseDataByCategory(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);
        
        $category = $request->input('category');

        $to = $enddate;
        $from = $startdate;

        $data       = Expense::where('branch_id', session('branch_id'))
                        ->select('expenses.signature', 'expense_categories.name','expenses.note' , \DB::raw('sum(amount) as amount, DATE(entry_date) as date'))
                        ->join('expense_categories','expenses.expense_category_id', '=', 'expense_categories.id')
                        ->where('expense_categories.parent_category', $category)
                        ->whereBetween('entry_date', [$from, $to])
                        ->groupby('date','expense_categories.name')
                        ->get();

        return response()->json(compact('data'));

    }

    public function loadVehiclesDataByHour(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);

        $data = Income::select(\DB::raw('count(id) as no_vehicles, sum(wax_amount > 0) as wax_amount, HOUR(entry_date) as hour'))
                        ->whereBetween('entry_date', [$startdate, $enddate])
                        ->whereIn('income_category_id', [1, 5, 3])
                        ->where('branch_id', session('branch_id'))
                        ->groupby('hour')->get();

        

        return response()->json(compact('data'));
    }

    public function loadVehiclesDataByDate(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);

        $data = Income::select(\DB::raw('count(id) as no_vehicles, sum(wax_amount > 0) as wax_amount, DATE(entry_date) as date'))
                        ->whereBetween('entry_date', [$startdate, $enddate])
                        ->whereIn('income_category_id', [1, 5, 3])
                        ->where('branch_id', session('branch_id'))
                        ->groupby('date')->get();

        

        return response()->json(compact('data'));
    }

    public function loadVehiclesDataByMonth(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);

        $data = Income::select(\DB::raw('count(id) as no_vehicles, sum(wax_amount > 0) as wax_amount, MONTH(entry_date) as month'))
                        ->whereBetween('entry_date', [$startdate, $enddate])
                        ->whereIn('income_category_id', [1, 5, 3])
                        ->where('branch_id', session('branch_id'))
                        ->groupby('month')->get();

        return response()->json(compact('data'));
    }

    public function loadCashFlowData(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($startdate, $interval ,$enddate);

        $incomes = Income::select(\DB::raw('sum(amount + wax_amount + fnb_amount) as amount, DATE(entry_date) as date'))
                        ->whereBetween('entry_date', [$startdate, $enddate])
                        ->join('accounts','payment_type_id', '=', 'accounts.id')
                        ->where('accounts.name', 'Cash')
                        ->where('branch_id', session('branch_id'))
                        ->groupby('date')->get();

        $expenses       = Expense::where('branch_id', session('branch_id'))
                        ->select(\DB::raw('sum(amount) as amount, DATE(entry_date) as date'))
                        ->join('accounts', 'from_id', '=', 'accounts.id')
                        ->where('accounts.name', 'cash')
                        ->whereBetween('entry_date', [$startdate, $enddate])
                        ->groupby('date')->get();
        
        $transfers_out  =   Transfer::where('branch_id', session('branch_id'))
                        ->select('note',\DB::raw('sum(jumlah) as amount, DATE(tanggal) as date'))
                        ->whereBetween('tanggal', [$startdate, $enddate])
                        ->join('accounts', 'dari_id', '=', 'accounts.id')
                        ->where('accounts.name', 'Cash')
                        ->groupby('date')->get();

        $transfers_in  =   Transfer::where('branch_id', session('branch_id'))
                        ->select('note',\DB::raw('sum(jumlah) as amount, DATE(tanggal) as date'))
                        ->whereBetween('tanggal', [$startdate, $enddate])
                        ->join('accounts', 'ke_id', '=', 'accounts.id')
                        ->where('accounts.name', 'Cash')
                        ->groupby('date')->get();

        $data = [];
        $i=0;
        $kas = 0;
        foreach ($daterange as $date) {
            
            $date_string = $date->format('Y-m-d');
            $expense = $expenses->first(function($item) use ($date_string){
                return $item->date == $date_string ;
            });

            $income = $incomes->first(function($item) use ($date_string){
                return $item->date == $date_string ;
            });


            $transfer_out = $transfers_out->first(function($item) use ($date_string){
                return $item->date == $date_string ;
            });

            $transfer_in = $transfers_in->first(function($item) use ($date_string){
                return $item->date == $date_string ;
            });

            $data[$i]['date'] = $date_string;
            $data[$i]['cash_expense'] = $expense['amount'];
            $data[$i]['cash_income'] = $income['amount'];
            $data[$i]['transfer_out'] = $transfer_out['amount'];
            $data[$i]['transfer_out_note'] = $transfer_out['note'];
            $data[$i]['transfer_in'] = $transfer_in['amount'];
            $data[$i]['transfer_in_note'] = $transfer_in['note'];

            $kas = $kas + $income['amount'] - $expense['amount'] + $transfer_in['amount'] - $transfer_out['amount'];
            $data[$i]['kas'] = $kas;
            $i++;
        };

        return response()->json(compact('data'));
    }



    public function viewIncomeStatement()
    {
        return view('reports.incomestatement');
    }

    public function viewCashFlow()
    {
        return view('reports.cashflow');
    }

}
