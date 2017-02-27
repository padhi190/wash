@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.tags.title')</h3>
    @can('tag_create')
    <p>
        <a href="{{ route('tags.create') }}" class="btn btn-success">@lang('quickadmin.add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.list')
        </div>

        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($tags) > 0 ? 'datatable' : '' }} @can('tag_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('tag_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.tags.fields.name')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($tags) > 0)
                        @foreach ($tags as $tag)
                            <tr data-entry-id="{{ $tag->id }}">
                                @can('tag_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $tag->name }}</td>
                                <td>
                                    @can('tag_view')
                                    <a href="{{ route('tags.show',[$tag->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.view')</a>
                                    @endcan
                                    @can('tag_edit')
                                    <a href="{{ route('tags.edit',[$tag->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.edit')</a>
                                    @endcan
                                    @can('tag_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.are_you_sure")."');",
                                        'route' => ['tags.destroy', $tag->id])) !!}
                                    {!! Form::submit(trans('quickadmin.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('quickadmin.no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('tag_delete')
            window.route_mass_crud_entries_destroy = '{{ route('tags.mass_destroy') }}';
        @endcan

    </script>
@endsection