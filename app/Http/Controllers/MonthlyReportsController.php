<?php
namespace App\Http\Controllers;

use App\Income;
use App\Expense;
use App\IncomeCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlyReportsController extends Controller
{
    public function index(Request $r)
    {
        $from    = Carbon::parse(sprintf(
            '%s-%s-01',
            $r->query('y', Carbon::now()->year),
            $r->query('m', Carbon::now()->month)
        ));
        $to      = clone $from;
        // $to->day = $to->daysInMonth;
        $to->addMonth();

        // cut off date from old format to new format:
        $new_format = Carbon::parse('2017-11-30 23:59:59');

        $use_new_format = $from > $new_format ? True : False;

        $exp_q = Expense::with('expense_category')
            ->whereBetween('entry_date', [$from, $to])
            ->where('branch_id', session('branch_id'));

        $inc_q = Income::with('income_category')
            ->whereBetween('entry_date', [$from, $to])
            ->where('branch_id', session('branch_id'));

        $exp_total = $exp_q->sum('amount');

        if($from < $new_format) {
            $inc_total = $inc_q->sum('amount');    
        }
        else{
            $inc_total = $inc_q->sum('fnb_amount')+$inc_q->sum('wax_amount')+$inc_q->sum('amount');
        }
        
        $exp_group = $exp_q->orderBy('amount', 'desc')->get()->groupBy('expense_category_id');
        $inc_group = $inc_q->orderBy('amount', 'desc')->get()->groupBy('income_category_id');
        $profit    = $inc_total - $exp_total;

        $exp_summary = [];
        foreach ($exp_group as $exp) {
            foreach ($exp as $line) {
                if (! isset($exp_summary[$line->expense_category->name])) {
                    $exp_summary[$line->expense_category->name] = [
                        'name'   => $line->expense_category->name,
                        'amount' => 0,
                    ];
                }
                $exp_summary[$line->expense_category->name]['amount'] += $line->amount;
            }
        }

        $inc_summary = [];
        foreach ($inc_group as $inc) {
            foreach ($inc as $line) {
                if (! isset($inc_summary[$line->income_category->name])) {
                    $inc_summary[$line->income_category->name] = [
                        'name'   => $line->income_category->name,
                        'amount' => 0,
                    ];
                }
                $inc_summary[$line->income_category->name]['amount'] += $line->amount;
            }
        }

        $inc_categories = IncomeCategory::all();

        $inc_detail = [];
        foreach ($inc_categories as $cat) {
            $inc_detail[$cat->name] = [
                'sales'     => Income::with('income_category')
                                ->whereBetween('entry_date', [$from, $to])
                                ->where('branch_id', session('branch_id'))
                                ->where('income_category_id', $cat->id)
                                ->count()
                                ,
                'vehicles'  => Income::with('income_category')
                                ->whereBetween('entry_date', [$from, $to])
                                ->where('branch_id', session('branch_id'))
                                ->where('income_category_id', $cat->id)
                                ->distinct()
                                ->count(['vehicle_id'])
                ];
        }

        $inc_total_s = $inc_total;
        if($inc_total == 0) {
            $inc_total_s = 1;
        }

        $exp_total_s = $exp_total;
        if($exp_total == 0) {
            $exp_total_s = 1;
        }

        $no_of_sales = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->count();

        $no_of_vehicles = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('branch_id', session('branch_id'))
                        ->distinct()
                        ->count(['vehicle_id']);

        $fnb_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('fnb_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('fnb_amount');

        $wax_dollar = Income::with('income_category')
                        ->whereBetween('entry_date', [$from, $to])
                        ->where('wax_amount', '>', '0')
                        ->where('branch_id', session('branch_id'))
                        ->sum('wax_amount');

        // dd($no_of_vehicles);
        
        if($no_of_vehicles>0){
            $average_frequency = $no_of_sales/$no_of_vehicles;    
        }
        else{
            $average_frequency = 0;
        }                
        
        if($no_of_sales>0){
            $average_spending = $inc_total/$no_of_sales;    
        }
        else{
            $average_spending = 0;
        }
                        
        return view('monthly_reports.index', compact(
            'exp_summary',
            'inc_summary',
            'exp_total',
            'inc_total',
            'profit',
            'inc_total_s',
            'exp_total_s',
            'inc_detail',
            'no_of_sales',
            'no_of_vehicles',
            'average_frequency',
            'average_spending',
            'fnb_dollar',
            'wax_dollar',
            'use_new_format'
        ));
    }
}