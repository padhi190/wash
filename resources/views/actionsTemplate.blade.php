<!-- @can($gateKey.'view')
    <a href="{{ route($routeKey.'.show', $row->id) }}"
       class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
@endcan -->
@can($gateKey.'edit')
    <a href="{{ route($routeKey.'.edit', $row->id) }}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span></a>
@endcan
<a href="#" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#printModal"><span class="glyphicon glyphicon-print" aria-hidden="true" id="print{{$row->id}}"></span></a>
@can($gateKey.'delete')
    {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'DELETE',
        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
        'route' => [$routeKey.'.destroy', $row->id])) !!}
    {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-xs btn-danger')) !!}
    {!! Form::close() !!}
@endcan

<script type="text/javascript">
    $(document).on("click", "#print{{$row->id}}", function () {
     // var myBookId = $(this).data('id');
    $(".modal-body #rcpt").html( "Rcpt No: {{$row->nobon}}" );
    $(".modal-body #date").html( "{{$row->entry_date}}" );
    $(".modal-body #vehicle").html( "<strong>{{$row->vehicle->license_plate}} - {{$row->vehicle->type}}</strong>" );
    $(".modal-body #kategori").html( "{{$row->income_category->name}} : Rp. {!! number_format($row->amount) !!}" );
    @if($row->wax_amount > 0)
        $(".modal-body #wax").html( "Wax : Rp. {!! number_format($row->wax_amount) !!}" );
    @else 
        $(".modal-body #wax").html( "" );
    @endif

    @if($row->fnb_amount > 0)
        $(".modal-body #fnb").html( "F&B : Rp. {!! number_format($row->fnb_amount) !!}" );
    @else 
        $(".modal-body #fnb").html( "" );
    @endif

    @if($row->fogging_amount > 0)
        $(".modal-body #fogging").html( "Fogging : Rp. {!! number_format($row->fogging_amount) !!}" );
    @else 
        $(".modal-body #fogging").html( "" );
    @endif

    $(".modal-body #total").html( "<strong>Total : Rp. {{ number_format($row->total_amount)}}</strong>" );
    });
</script>
    