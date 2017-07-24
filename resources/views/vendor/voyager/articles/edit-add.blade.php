@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        .file-image-size > iframe{
            max-width: 200px !important;
            max-height: 150px !important;
        }
        .newwy > img {
            max-width: 200px;
        }
    </style>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title">@if(isset($dataTypeContent->id)){{ 'Редактирование' }}@else{{ 'Добавление' }}@endif {{ $dataType->display_name_singular }}</h3>
                    </div>
                    <!-- /.box-header -->
                     @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    <!-- form start -->
                    <form role="form"
                          action="@if(isset($dataTypeContent->id))/admin/articles/{{ $dataTypeContent->slug}}@else /admin/articles @endif"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                            @if(isset($dataTypeContent->id))
                                {{ method_field("PUT") }}
                            @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> Post Title
                                <span class="panel-desc"> Название новости</span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="name" placeholder="Name" value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel col-md-8" >
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> Контент новости</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <textarea class="richTextBox" name="body" style="border:0px;">@if(isset($dataTypeContent->body)){{ $dataTypeContent->body }}@endif</textarea>
                    </div><!-- .panel -->                   
                    <div class="panel col-md-4">
                    <!-- ### DETAILS ### -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> Контент новости</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="file">Главное фото</label>                                
                                @if(isset($dataTypeContent->media))
                                    <div class="newwy fileType file-image-size">{!! $dataTypeContent->media !!}</div>
                                    <input type="checkbox" name="rmfile">удалить фото                                    
                                @endif
                                <input type="file" name="media">
                            </div>
                            <div class="form-group">
                                <label for="is_anchored">Закрепить на главную</label>
                                <input type="checkbox" name="is_anchored" class="toggleswitch"  {!! (isset($dataTypeContent->is_anchored) && $dataTypeContent->is_anchored === 1) ? 'checked="checked"' : '' !!}">
                            </div>
                            <div class="form-group">                            
                                <label for="anchored_from">Закрепить от</label>
                                <input type="datetime" class="form-control datepicker" name="anchored_from"
       value="@if(isset($dataTypeContent->anchored_from)){{ gmdate('m/d/Y g:i A', strtotime(old('anchored_from', $dataTypeContent->anchored_from)))  }}@else{{old('anchored_from')}}@endif">
                            </div>
                            <div class="form-group">                            
                                <label for="anchored_to">Закрепить до</label>
                                <input type="datetime" class="form-control datepicker" name="anchored_to"
       value="@if(isset($dataTypeContent->anchored_to)){{ gmdate('m/d/Y g:i A', strtotime(old('anchored_to', $dataTypeContent->anchored_to)))  }}@else{{old('anchored_to')}}@endif">
                            </div>
                            <div class="form-group">
                                <label for="is_highlighted">Выделить новость</label>
                                <input type="checkbox" name="is_highlighted" class="toggleswitch"  {!! (isset($dataTypeContent->is_highlighted) && $dataTypeContent->is_highlighted === 1) ? 'checked="checked"' : '' !!}">
                            </div>
                            <div class="form-group">
                                <label for="tags">Тэги</label>
                                <input type="text" class="form-control" name="tags" value="@if(isset($dataTypeContent->tags)){{ implode(', ', $dataTypeContent->tags->pluck('name')->toArray()) }}@endif" placeholder="Вводите теги через &quot;,&quot;">
                            </div>
                            @if(Auth::user()->role->name === 'admin')
                                <div class="form-group">
                                    <label for="city_id">Город</label>
                                    <select class="form-control" name="city_id">
                                        <option value="0" selected>Выберите город</option> 
                                        <option value="0">Все</option>

                                        @foreach(App\City::all() as $city)
                                            <option value="{{$city->id}}" @if(isset($dataTypeContent->city_id) && $dataTypeContent->city_id === $city->id){{ 'selected="selected"' }}@endif>{{ $city->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="department_id">Департамент</label>
                                    <select class="form-control" name="department_id">
                                        <option value="0" selected>Выберите департамент</option>
                                        <option value="0">Все</option>
                                        @foreach(App\Department::all() as $department)
                                            <option value="{{$department->id}}" @if(isset($dataTypeContent->department_id) && $dataTypeContent->department_id === $department->id){{ 'selected="selected"' }}@endif>{{ $department->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>                  
                    </div>                  

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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


