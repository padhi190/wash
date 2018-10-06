@can($gateKey.'edit')
    <!-- <a href="{{ route($routeKey.'.edit', $row->id) }}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span></a> -->
    {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'POST',
        'onsubmit' => "return confirm('restore this record?');",
        'route' => [$routeKey.'.restore', $row->id])) !!}
    {!! Form::button('<span class="glyphicon glyphicon-repeat"></span>', array('type'=>'submit' ,'class' => 'btn btn-xs btn-success')) !!}
    {!! Form::close() !!}
@endcan

@can($gateKey.'delete')
    {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'DELETE',
        'onsubmit' => "return confirm('permanently delete this record?');",
        'route' => [$routeKey.'.permanentdestroy', $row->id])) !!}
    {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', array('type'=>'submit' ,'class' => 'btn btn-xs btn-danger')) !!}
    {!! Form::close() !!}
@endcan