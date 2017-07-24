@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">
        .file-image-size > iframe{
            max-width: 200px !important;
            max-height: 150px !important;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> Новости
        @if (Voyager::can('add_'.$dataType->name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success">
                <i class="voyager-plus"></i> Добавить
            </a>
        @endif
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Содержание</th>
                                    <th>Время создания</th>
                                    <th>Обрамлена</th>
                                    <th>Прикреплена</th>
                                    @if(Auth::user()->role->name === 'admin')
                                        <th>Департамент</th>
                                        <th>Город</th>                                    
                                    @endif
                                    <th class="actions">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            if(Auth::user()->role->name !== 'admin')
                            {
                                $dataTypeContent = $dataTypeContent->where('city_id', Auth::user()->city_id)->where('department_id', Auth::user()->department_id)->all();
                            }
                            @endphp
                            @foreach($articles as $data)
                                <tr>
                                    <td>{{$data->name}}</td>
                                    <td>{{str_limit(mediaLess($data->body), 300, '...') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('F jS, Y h:i A') }}</td> 
                                    <td>@if($data->is_highlighted)+@else-@endif</td>
                                    <td>@if($data->is_anchored)+@else-@endif</td>                             
                                    @if(Auth::user()->role->name === 'admin')
                                        <td>@if(isset($data->department)){{ $data->department->name }}@else-@endif</td>
                                        <td>@if(isset($data->city)){{ $data->city->name }}@else-@endif</td>
                                    @endif
                                    <td class="no-sort no-click">
                                        @if(haveRightsOn($data))                                    
                                            @if (Voyager::can('delete_'.$dataType->name))
                                                <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}" id="delete-{{ $data->id }}">
                                                    <i class="voyager-trash"></i> <!-- Delete -->
                                                </div>
                                            @endif
                                            @if (Voyager::can('edit_'.$dataType->name))
                                                <a href="{{ route('voyager.'.$dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <!-- Edit -->
                                                </a>
                                            @endif
                                            @if (Voyager::can('read_'.$dataType->name))
                                                <a href="/articles/{{$data->slug}}" class="btn-sm btn-warning pull-right">
                                                    <i class="voyager-eye"></i> <!-- View -->
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if (isset($dataType->server_side) && $dataType->server_side)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">Showing {{ $dataTypeContent->firstItem() }} to {{ $dataTypeContent->lastItem() }} of {{ $dataTypeContent->total() }} entries</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы уверены, что хотите удалить эту новость?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                 value="Да, удалить новость.">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        @if (!$dataType->server_side)
            $(document).ready(function () {
                $('#dataTable').DataTable({ "order": [] });
            });
        @endif

        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];

            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                    ? action.replace(/([0-9]+$)/, id)
                    : action + '/' + id;
        }
    </script>
@stop
