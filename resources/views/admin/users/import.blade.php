@extends('voyager::master')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div>
                            <form action="/admin/import-users" method="POST" role="form" enctype="multipart/form-data">
                                <legend>Импорт Сотрудников</legend>

                                {{csrf_field()}}
                            
                                <div class="form-group">
                                    <label for="users">Загрузите список сотрудников (.сsv)</label>
                                    <input type="file" name="users" accept=".csv" v-model="users" required="required" >
                                </div>

                                <div class="form-group">
                                    <label for="photos">Загрузите фотографии сотрудников</label>
                                    <input type="file" name="photos" v-model="photos" accept=".zip" >
                                </div>   

                                <button type="submit" class="btn btn-primary">Загрузить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@stop

@section('javascript')

@stop
