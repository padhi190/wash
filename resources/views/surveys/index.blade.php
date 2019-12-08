@extends('layouts.app')

@section('content')
    <h3 class="page-title"><i class="fa fa-calculator"></i>Survey Results</h3>
    <br>
    
    <div class="row">
        <div class="col-xs-6">
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <div class="col-xs-6">
            {!! Form::select('survey_template_id', $survey_template_id, old('survey_template_id'), ['class' => 'form-control select', 'id' => 'survey_template_select']) !!}
        </div>
    </div>
    

     <p>
        {{ Form::hidden('startdate', old('startdate', Carbon\Carbon::today()->subDays(14)->format('d-m-Y')), ['id' => 'startdate']) }}
        {{ Form::hidden('enddate', old('enddate', Carbon\Carbon::today()->format('d-m-Y')), ['id' => 'enddate']) }}
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped" id="survey-table">
                <thead>
                    <tr>
                        <th>No Bon</th>
                        <th>Jumlah</th>
                        <th id="q1">q1</th>
                        <th id="q2">q2</th>
                        <th id="q3">q3</th>
                        <th id="q4">q4</th>
                        <th id="q5">q5</th>
                        <th id="essay">Essay</th>
                        
                        <!-- <th>&nbsp</th> -->
                    </tr>
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />  
    <script>
        

         $( document ).ready(function() {
            var dtable = $('#survey-table').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    pageLength: '10',
                    searchDelay: 450,
                    processing: true,
                    serverSide: true,
                    order: [[1, 'desc']],
                    ajax: {
                        url: '{!! route($ajaxurl) !!}',
                        data: function(d) {
                            d.startdate = $('input[name=startdate]').val();
                            d.enddate = $('input[name=enddate]').val();
                            d.survey_template_id = $('#survey_template_select').val();
                        }
                    },
                    columns: [
                        { data: 'income_id' },
                        { data: 'amount', searchable: false, orderable: false },
                        { data: 'q1'},
                        { data: 'q2'},
                        { data: 'q3'},
                        { data: 'q4' },
                        { data: 'q5' },
                        { data: 'essay'},
                    ]
                });
            
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            function cb(start, end) {
                $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                $('input[name=startdate]').val(start.format('D-M-YYYY'));
                $('input[name=enddate]').val(end.format('D-M-YYYY'));
                dtable.draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                   'Hari ini': [moment(), moment()],
                   'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   '7 Hari terakhir': [moment().subtract(6, 'days'), moment()],
                   '14 Hari terakhir': [moment().subtract(14, 'days'), moment()],
                   'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                   'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
            $("#survey_template_select").on("change", function(){
                // cb($('input[name=startdate]').val(), $('input[name=enddate]').val());
                enddate = moment($('input[name=enddate]').val(), "DD-MM-YYYY");
                startdate = moment($('input[name=startdate]').val(), "DD-MM-YYYY");
                // alert(this.value);
                cb(startdate, enddate);
            });
        });

    </script>
@endsection