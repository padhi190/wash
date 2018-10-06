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
    $(".modal-body #rcpt").html( "No Bon: {{$row->id}}" );
    $(".modal-body #date").html( "{{$row->entry_date}}" );
    $(".modal-body #kategori").html( "{{$row->expense_category->name}}" );
    
    $(".modal-body #total").html( "<strong>Total : Rp. {{ number_format($row->amount)}}</strong>" );
    @if($row->signature!='')
        $(".modal-body #signature").css("margin-top","15mm");
        $(".modal-body #signature").html( "({{$row->signature}})" );
    @else
        $(".modal-body #signature").css("margin-top","0mm");
        $(".modal-body #signature").html( "" );
    @endif

    });
</script>
    