@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        @if (Voyager::can('add_'.$dataType->name))
            <span>
                <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success">
                    <i class="voyager-plus"></i> Добавить
                </a>
            </span>
            @if(auth()->user()->role->name == 'admin')
                <span>
                    <a href="/admin/import-users/" class="btn">
                        <i class="voyager-plus"></i> Импорт сотрудников
                    </a>                
                </span>
            @endif
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
                                    <th>Аватар</th>
                                    <th>Имя</th>
                                    <th>Город</th>
                                    <th>Департамент</th>
                                    <th>Должность</th>
                                    @if(auth()->user()->role->name === 'admin')
                                        <th>Роль</th>
                                    @endif
                                    <th class="actions">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                if(auth()->user()->role->name !== 'admin')
                                {
                                    $dataTypeContent = $dataTypeContent->where('city_id', auth()->user()->city_id)->where('department_id', auth()->user()->department_id)->all();
                                }
                            @endphp
                            @foreach($users as $data)
                                <tr>
                                    <td>
                                        <img src="{{ $data->photo }}" style="width:35px">
                                    </td>
                                    <td>{{ucwords($data->name)}}</td>
                                    <td>{{isset($data->city) ? $data->city->name : '-'}}</td>
                                    <td>{{isset($data->department) ? $data->department->name : '-'}}</td>
                                    <td>{{isset($data->position) ? $data->position->name : '-'}}</td>
                                    @if(auth()->user()->role->name === 'admin')                                    
                                        <td>{{ $data->role ? $data->role->display_name : '' }}</td>
                                    @endif
                                    <td class="no-sort no-click" style="display: flex">
                                        @if (Voyager::can('edit_'.$dataType->name))
                                            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                                <i class="voyager-edit"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->role->name === 'admin')             
                                            <div class="btn-sm btn-warning pull-right refresh" style="cursor: pointer; margin-left: 5px" data-email="{{ $data->email }}" data-id="{{ $data->id }}" id="refresh-{{ $data->id }}">
                                                <i class="voyager-refresh"></i>
                                            </div>      
                                        @endif
                                        @if (Voyager::can('delete_'.$dataType->name))
                                            <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}" id="delete-{{ $data->id }}">
                                                <i class="voyager-trash"></i>
                                            </div>
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
                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы хотите удалить этого пользователя?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                 value="Да, удалить этого пользователя">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal modal-warning fade" tabindex="-1" id="refresh_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы хотите сбросить пароль этого пользователя?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ url('/password/email') }}" id="refresh_form" method="POST">
                        {{ csrf_field() }}
                        <input type="email" name="email" id="inputEmail" class="form-control" value="" required="required" title="">
                        <input type="submit" class="btn btn-warning pull-right delete-confirm"
                                 value="Да, сбросить пароль">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    <script src="/js/jquery-fields.min.js"></script>
    <script>
        @if (!$dataType->server_side)
            $(document).ready(function () {
                $('#dataTable').DataTable({ "order": [] });
            });
        @endif

        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];
            console.log(form.action, $(this).data());
            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });
        $('td').on('click', '.refresh', function (e) {
            var form =  $('form#refresh_form').fields();
            form.email.val($(this).data('email'));

            $('#refresh_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                    ? action.replace(/([0-9]+$)/, id)
                    : action + '/' + id;
        }
    </script>
@stop
