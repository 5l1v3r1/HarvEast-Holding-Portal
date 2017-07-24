@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
<br>
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container panel panel-bordered">
                <div class="panel-body table-responsive">
                    <form action="/admin/infos" method="POST" enctype="multipart/form-data"> 
                        {{csrf_field()}}
                        <div class="row col-md-12">
                        @if(Auth::user()->role->name === 'admin')
                            @foreach(App\City::all() as $city)
                                <div class="row col-md-12">
                                    <div class="col-md-12">
                                        <div class="dataTables_length">
                                            <h4>{{$city->name}}</h4>
                                        </div>
                                    </div>
                                        @foreach(App\Department::all() as $department)
                                            <div class="col-md-2">
                                                <div class="dataTables_length">
                                                    <h6>{{$department->name}}</h6>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="dataTables_length">
                                                    <label></label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                @php
                                                    $info = App\Info::exists($city->id, $department->id);
                                                @endphp
                                                <input type="text" class="form-control" name="title[{{$city->id}}][{{$department->id}}]" placeholder="Название блока" @if($info) value="{{$info->name}}" @endif>
                                                <br>
                                                <textarea name="body[{{$city->id}}][{{$department->id}}]" id="input" class="form-control" rows="3">
                                                	@if($info) {{$info->body}} @endif
                                                </textarea>
                                            	<span>Фото</span> 					                                                              
				                                @if(isset($info->photo))
				                                    <div class="fileType file-image-size"><img style="max-width: 150px" src="{{$info->photo}}"></img></div>
				                                    <input type="checkbox" name="rmfile[{{$city->id}}][{{$department->id}}]">удалить фото
				                                @endif
				                                <input class="form-control" type="file" name="photo[{{$city->id}}][{{$department->id}}]" accept="image/*"/>
                                            </div>
                                        @endforeach
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>  
                        @endforeach 
                        @else
                            <div>
                                @php
                                    $city_id = Auth::user()->city_id;
                                    $department_id = Auth::user()->department_id;
                                    $info = App\Info::exists($city_id, $department_id);
                                @endphp
                                <input type="text" class="form-control" name="title[{{$city_id}}][{{$department_id}}]" placeholder="TITLE" @if($info) value="{{$info->name}}" @endif>
                                <br>
                                <textarea class="richTextBox" name="body[{{$city_id}}][{{$department_id}}]" style="border:0px;" >@if($info) {{$info->body}} @endif</textarea>
                                <span>Фото</span> 					                                                              
                                @if(isset($info->photo))
                                    <div class="fileType file-image-size"><img src="{{$info->photo}}"></img></div>
				                    <input type="checkbox" name="rmfile[{{$city->id}}][{{$department->id}}]">удалить фото

                                @endif
                                <input class="form-control" type="file" name="photo[{{$city_id}}][{{$department_id}}]" accept="image/*"/>
                            </div>
                        @endif                       
                        <input type="submit" class="btn btn-success" name="submit" value="Сохранить">
                    </form>
                </div>  
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
@stop