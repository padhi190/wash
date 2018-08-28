@extends('layouts.app')

@section('content')
    <h3 class="page-title">Monthly Report</h3>

    {!! Form::open(['method' => 'get']) !!}
        <div class="row">
            <div class="col-xs-1 col-md-1 form-group">
                {!! Form::label('year','Year',['class' => 'control-label']) !!}
                {!! Form::select('y', array_combine(range(date("Y"), 1900), range(date("Y"), 1900)), old('y', Request::get('y', date('Y'))), ['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-2 col-md-2 form-group">
                {!! Form::label('month','Month',['class' => 'control-label']) !!}
                {!! Form::select('m', cal_info(0)['months'], old('m', Request::get('m', date('m'))), ['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-4">
                <label class="control-label">&nbsp;</label><br>
                {!! Form::submit('Select month',['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}

    
    <div class="panel panel-default">
        <div class="panel-heading">
            Report
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Penjualan</th>
                            <td style="text-align: right;">{{ number_format($inc_total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Pengeluaran</th>
                            <td style="text-align: right;">{{ number_format($exp_total, 2) }} ({{number_format($exp_total/$inc_total_s * 100, 1)}}%)</td>
                        </tr>
                        <tr>
                            <th>Profit</th>
                            <td style="text-align: right;">{{ number_format($profit, 2) }} ({{number_format($profit/$inc_total_s * 100, 1)}}%)</td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Penjualan</th>
                            <td style="text-align: right;">{{ number_format($inc_total, 2) }}</td>
                        </tr>
                         <tr>
                            <th>Jumlah Kendaraan</th>
                            <td style="text-align: right;">{{ number_format($no_of_vehicles, 0) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Penjualan</th>
                            <td style="text-align: right;">{{ number_format($no_of_sales, 0) }}</td>
                        </tr>
                        <tr>
                            <th>Frekuensi Kedatangan</th>
                            <td style="text-align: right;">{{ number_format($average_frequency, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Rata2 Cust. Spending</th>
                            <td style="text-align: right;">{{ number_format($average_spending, 0) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Penjualan by category</th>
                            <th style="text-align: right;">{{ number_format($inc_total, 2) }}</th>
                        </tr>
                    @foreach($inc_summary as $inc)
                        <tr>
                            <th>{{ $inc['name'] }}</th>
                            <td style="text-align: right;">{{ number_format($inc['amount'], 2) }} ({{number_format($inc['amount']/$inc_total_s * 100, 1)}}%)</td>
                        </tr>
                    @endforeach
                    @if($use_new_format)
                        <tr>
                            <th>Wax</th>
                            <td style="text-align: right;">{{ number_format($wax_dollar, 2) }} ({{number_format($wax_dollar/$inc_total_s * 100, 1)}}%)</td>
                        </tr>
                        <tr>
                            <th>F&B</th>
                            <td style="text-align: right;">{{ number_format($fnb_dollar, 2) }} ({{number_format($fnb_dollar/$inc_total_s * 100, 1)}}%)</td>
                        </tr>
                    @endif
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Pengeluaran by category</th>
                            <th style="text-align: right;">{{ number_format($exp_total, 2) }}</th>
                        </tr>
                    @foreach($exp_summary as $inc)
                        <tr>
                            <th>{{ $inc['name'] }}</th>
                            <td style="text-align: right;">{{ number_format($inc['amount'], 2) }} ({{number_format($inc['amount']/$exp_total_s * 100, 1)}}%)</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Income Detail
        </div>

        <div class="panel-body">
            <?php $i=0;?>
            @foreach($inc_summary as $inc)
            <?php if($i%3==0) echo '<div class="row">'?>
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>{{ $inc['name'] }}</th>
                            <th style="text-align: right;">{{ number_format($inc['amount'], 2) }}</th>
                        </tr>
                        <tr>
                            <td>Jumlah Kendaraan</td>
                            <td style="text-align: right;">{{ number_format($inc_detail[$inc['name']]['vehicles'], 0) }} </td>
                        </tr>
                        <tr>
                            <td>Jumlah Penjualan</td>
                            <td style="text-align: right;">{{ number_format($inc_detail[$inc['name']]['sales'], 0) }} </td>
                        </tr>
                        <tr>
                            <td>Frekuensi</td>
                            <td style="text-align: right;">{{ number_format($inc_detail[$inc['name']]['sales']/$inc_detail[$inc['name']]['vehicles'], 2) }} </td>
                        </tr>
                        <tr>
                            <td>Rata2 Cust. Spending</td>
                            <td style="text-align: right;">{{ number_format($inc['amount']/$inc_detail[$inc['name']]['sales'], 2) }} </td>
                        </tr>
                    </table>
                </div>
            <?php 
                if($i%3==2) echo '</div>';
                $i+=1; 
            ?>
            @endforeach
        </div>
        
    </div>
@stop