@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .nextPhone + .nextPhone {
            margin-top: 5px;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ 'Редактировать пользователя' }}@else{{ 'Новый пользователь' }}@endif
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title">@if(isset($dataTypeContent->id)){{ 'Редактировать  пользователя' }}@else{{ 'Добавить нового пользователя' }}@endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form"
                          action="@if(isset($dataTypeContent->id))/admin/users/{{ $dataTypeContent->id}}@else /admin/users @endif"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Фамилия Имя Отчество</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Фамилия Имя Отчество" id="name"
                                    value="@if(isset($dataTypeContent->name)){{ old('name', $dataTypeContent->name) }}@else{{old('name')}}@endif">
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" name="email"
                                       placeholder="Email" id="email"
                                       value="@if(isset($dataTypeContent->email)){{ old('email', $dataTypeContent->email) }}@else{{old('email')}}@endif">
                            </div>

                            <div class="form-group">
                                <label for="photo">Фото</label>
                                @if(isset($dataTypeContent->photo) && $dataTypeContent->photo)
                                    <img src="{{$dataTypeContent->photo}}"
                                         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                @endif
                                <input type="file" name="photo">
                            </div>

                            @if(auth()->user()->role->name === 'admin')
                                <div class="form-group">
                                    <label for="role">Город</label>
                                    <select name="city_id" id="city" class="form-control">
                                        @php $cities = App\City::all(); @endphp
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if(isset($dataTypeContent) && $dataTypeContent->city_id == $city->id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="department">Департамент</label>
                                    <select name="department_id" id="department" class="form-control">
                                        @php $departments = App\Department::all(); @endphp
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if(isset($dataTypeContent) && $dataTypeContent->department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="role">Роль</label>
                                    <select name="role_id" id="role" class="form-control">
                                            <option value="{{App\Role::where('name', 'user')->first()->id}}" selected blocked>Выберите роль</option>
                                        @foreach(App\Role::all() as $role)
                                            <option value="{{$role->id}}" @if(isset($dataTypeContent) && $dataTypeContent->role_id == $role->id) selected @endif>{{$role->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif    

                            <div class="form-group">
                                <label for="role">Должность</label>
                                <select name="position_id" id="position" class="form-control">
                                    @foreach(App\Position::all() as $position)
                                        <option value="{{$position->id}}" @if(isset($dataTypeContent) && $dataTypeContent->position_id == $position->id) selected @endif>{{$position->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(isset($dataTypeContent->id))
                                <div class="form-group">
                                    <label for="phone">Телефоны</label>
                                    @php
                                        $phones = App\Phone::where('user_id', $dataTypeContent->id)->get();
                                    @endphp
                                    @foreach($phones as $phone)
                                        <input type="phone" class="form-control nextPhone" name="phone[]"
                                            placeholder="Телефон" id="phone"
                                            value="{{$phone->phone}}">
                                    @endforeach
                                    @for($i = 1; $i < (5 - $phones->count()); $i++)
                                        <input type="phone" class="form-control nextPhone" name="phone[]"
                                            placeholder="Телефон" id="phone"
                                            value="">
                                    @endfor
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="phone">Телефоны</label>
                                    @for($i = 1; $i < 5; $i++)
                                        <input type="phone" class="form-control nextPhone" name="phone[]"
                                            placeholder="Телефон" id="phone"
                                            value="">
                                    @endfor
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="birthday">День рождения</label>
                                <input type="date" class="form-control" name="birthday"
                                    placeholder="День рождения"
                                    value="@if(isset($dataTypeContent->birthday)){{$dataTypeContent->birthday->format('Y-m-d')}}@else{{old('birthday')}}@endif">
                            </div>       
                            <div class="form-group">
                                <label for="boss">Начальник</label>
                                <select name="boss_id" id="boss" class="form-control select2">
                                    <option value="0" selected>Нет начальника</option>
                                    @foreach(App\User::orderBy('name')->get() as $boss)
                                        <option value="{{$boss->id}}" @if(isset($dataTypeContent) && $dataTypeContent->boss_id == $boss->id) selected @endif>{{$boss->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
    <script src="{{ config('voyager.assets_path') }}/lib/js/tinymce/tinymce.min.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/voyager_tinymce.js"></script>
@stop
