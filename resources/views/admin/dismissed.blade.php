@extends('voyager::master')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if($dismissed_users->count())
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
                                        $dismissed_users = $dismissed_users->where('city_id', auth()->user()->city_id)->where('department_id', auth()->user()->department_id)->all();
                                    }
                                @endphp
                                @foreach($dismissed_users as $data)
                                    <tr>
                                        <td>
                                            <img src="@if( strpos($data->photo, 'http://') === false && strpos($data->photo, 'https://') === false){{ Voyager::image( $data->photo ) }}@else{{ $data->photo }}@endif" style="width:35px">
                                        </td>
                                        <td>{{ucwords($data->name)}}</td>
                                        <td>{{isset($data->city) ? $data->city->name : '-'}}</td>
                                        <td>{{isset($data->department) ? $data->department->name : '-'}}</td>
                                        <td>{{isset($data->position) ? $data->position->name : '-'}}</td>
                                        @if(auth()->user()->role->name === 'admin')                                    
                                            <td>{{ $data->role ? $data->role->display_name : '' }}</td>
                                        @endif
                                        <td class="no-sort no-click">
                                                <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}" id="delete-{{ $data->id }}">
                                                    Восстановить
                                                </div>
                                        </td>
                                    </tr>

                                    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы уверены, что хотите восстановить этого пользователя?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="/admin/dismissed/{{$data->id}}" id="delete_form" method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                                                 value="Да, восстановить">
                                                    </form>
                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <p>Нет пользователей для восстановления.</p>
                            @endif
                        @if (isset($dataType->server_side) && $dataType->server_side)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">Showing {{ $dismissed_users->firstItem() }} to {{ $dismissed_users->lastItem() }} of {{ $dismissed_users->total() }} entries</div>
                            </div>
                            <div class="pull-right">
                                {{ $dismissed_users->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
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
