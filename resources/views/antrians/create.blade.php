@extends('layouts.app')

@section('content')

<h3 class="page-title">Antrian</h3>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
</div>

{!! Form::open(['id' => 'antriForm', 'method' => 'POST', 'route' => ['antrians.store']]) !!}

<div class="panel panel-default">
        
        
    <div class="panel-body">
        {{ Form::hidden('branch_id', Session::get('branch_id'))}}

        <div class="row">
          <div class="col-md-12 form-group">
            {!! Form::label('vehicle_id', 'Cari Kendaraan*', ['class' => 'control-label']) !!}
            {!! Form::select('vehicle_id', ["" => "Cari"], null, ['class' => 'form-control vehicle_search', 'id' => 'new_vehicle_search', 'style' => 'width:100%']) !!}
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 form-group">
            {!! Form::label('license_plate', 'Plat No.*', ['class' => 'control-label']) !!}
            {!! Form::text('license_plate', old('license_plate'), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:uppercase', 'id'=>'antrian_license_plate']) !!}
          </div>

          <div class="col-md-6 form-group">
            {!! Form::label('brand', 'Brand', ['class' => 'control-label']) !!}
            {!! Form::text('brand', old('brand'), ['class' => 'form-control','style' => 'text-transform:capitalize', 'placeholder' => '', 'id' => 'antrian_brand']) !!}
          </div>

        </div>


        <div class="row">
          <div class="col-md-6 form-group">
            {!! Form::label('model', 'Model', ['class' => 'control-label']) !!}
            {!! Form::text('model', old('model'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_model']) !!}
          </div>

          <div class="col-md-6 form-group">
            {!! Form::label('color', 'Warna', ['class' => 'control-label']) !!}
            {!! Form::text('color', old('color'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_color']) !!}
          </div>

        </div>

        <div class="row">
          <div class="col-md-6 form-group">
            {!! Form::label('type', 'Type*', ['class' => 'control-label']) !!}
            <br>
            <div class="btn-group btn-group-justified" data-toggle="buttons">
                <label id="antrian_mobil" class="btn btn-primary active">
                    <input type="radio" name="type" value='mobil' autocomplete="off" checked> Mobil
                </label>
                <label id="antrian_motor" class="btn btn-primary">
                    <input type="radio" name="type" value='motor' autocomplete="off" > Motor
                </label>
            </div>  
          </div>

          <div class="col-md-6 form-group">
                {!! Form::label('arrival_time', 'Tanggal*', ['class' => 'control-label']) !!}
                {!! Form::text('arrival_time', old('arrival_time', Carbon\Carbon::now()->format('d-m-Y H:i')), ['class' => 'form-control datetime', 'placeholder' => '', 'id'=>'datepicker']) !!}
          </div>

        </div>

        <div class="row">
          <div class="col-md-6 form-group">
            {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
            <br>
            <div class="btn-group btn-group-justified" data-toggle="buttons">
                <label id="antrian_tunggu" class="btn btn-primary active">
                    <input type="radio" name="status" value='Ditunggu' autocomplete="off" checked> Tunggu
                </label>
                <label id="antrian_tinggal" class="btn btn-primary">
                    <input type="radio" name="status" value='Ditinggal' autocomplete="off" > Tinggal
                </label>
            </div>  
          </div>

          <div class="col-md-6 form-group">
            {!! Form::label('customer', 'Customer', ['class' => 'control-label']) !!}
            <br>
            <div class="btn-group btn-group-justified" data-toggle="buttons">
                <label id="antrian_new" class="btn btn-primary active">
                    <input type="radio" name="customer" value='New' autocomplete="off" checked> Baru
                </label>
                <label id="antrian_existing" class="btn btn-primary">
                    <input type="radio" name="customer" value='Existing' autocomplete="off" > Lama
                </label>
            </div>  
          </div>

        </div>

        <div class="row">
          <div class="col-md-6 form-group">
            {!! Form::label('name', 'Nama', ['class' => 'control-label']) !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_name']) !!}
          </div>

          <div class="col-md-6 form-group">
            {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
            {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'style' => 'text-transform:capitalize','placeholder' => '', 'id' => 'antrian_phone']) !!}
          </div>

        </div>

        <div class="row">
	        <div class="col-xs-6 form-group">
	            {!! Form::submit(trans('quickadmin.save'), ['class' => 'btn btn-danger btn-lg']) !!}
	        </div>
	    </div>

        
    </div>

   
    {!! Form::close() !!}

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.0/locale/id.js"></script> 
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
    $(document).ready(function(){
    	var maxDate = new Date();
        maxDate.setMinutes(maxDate.getMinutes() + 60);

        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm",
            maxDate:maxDate,
            stepMinute: 1,
            showSecond: false,
            controlType: 'select',
            showMillisec:false,
            showMicrosec:false
        });

        $('#new_vehicle_search').select2({
                minimumInputLength: 3,
                width: 'resolve', 
                placeholder:'Cari...',
                ajax: {
                  url: "{!! route('loadVehiclesData') !!}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    var results = [];
                    $.each(data, function (index, vehicles) {
                        results.push({
                            id: vehicles.id,
                            text: vehicles.license_plate + " | " + vehicles.brand.toUpperCase() + ", " +vehicles.model.toUpperCase() + ", " + vehicles.color.toUpperCase() + " | " + vehicles.customer.name + ", " + vehicles.customer.phone + ", " +vehicles.type.toUpperCase() 
                        });
                    });

                    return {
                        results: results
                    };
                  },
                }
            }).on('select2:open', () => {
                    $(".select2-results:not(:has(a))").append('<a href="#" style="padding: 6px;height: 20px;display: inline-table;" onclick="copyData()">Copy Plat No</a>');
            }).on('select2:select', function (e) {
                var data = e.params.data;
                var s_text = data['text'];
                var split_text = s_text.split('|');
                var license_plate = split_text[0];
                var brand = split_text[1].split(',')[0];
                var model = split_text[1].split(',')[1];
                var color = split_text[1].split(',')[2];
                var type = $.trim(split_text[2].split(',')[2]);
                var name = $.trim(split_text[2].split(',')[0]);
                var phone = $.trim(split_text[2].split(',')[1]);
                // alert(data['text']);
                $('#antrian_license_plate').val($.trim(license_plate));
                $('#antrian_brand').val($.trim(brand));
                $('#antrian_model').val($.trim(model));
                $('#antrian_color').val($.trim(color));
                $('#antrian_name').val(name);
                $('#antrian_phone').val(phone);

                if(type == 'MOTOR')
                    $('#antrian_motor').button('toggle');
                else
                    $('#antrian_mobil').button('toggle');

                $('#antrian_existing').button('toggle');
            });
     });

    function copyData(){
        var searchtext = $("#new_vehicle_search").data("select2").dropdown.$search.val()
        // alert(searchtext);
        $('#antrian_license_plate').val(searchtext);
        $('#new_vehicle_search').select2("close");
        $('#antrian_brand').val('');
        $('#antrian_model').val('');
        $('#antrian_color').val('');
        $('#antrian_name').val('');
        $('#antrian_phone').val('');
        $('#antrian_mobil').button('toggle');
        $('#antrian_new').button('toggle');
        $("#datepicker").datetimepicker("setDate", new Date());
    };

    </script>
@stop