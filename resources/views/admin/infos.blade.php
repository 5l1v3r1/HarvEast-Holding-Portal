@extends('voyager::master')

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
                                    <div class="col-md-1">
                                        <div class="dataTables_length">
                                            <label>{{$city->name}}</label>
                                        </div>
                                    </div>
                                        @foreach(App\Department::all() as $department)
                                            <div class="col-md-2">
                                                <div class="dataTables_length">
                                                    <label>{{$department->name}}</label>
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
                                                <input type="text" class="form-control" name="title[{{$city->id}}][{{$department->id}}]" placeholder="TITLE" @if($info) value="{{$info->name}}" @endif>
                                                <br>
                                                <textarea class="richTextBox col-md-12" name="body[{{$city->id}}][{{$department->id}}]" style="border:0px;" >@if($info) {{$info->body}} @endif</textarea>
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
                            </div>
                        @endif                       
                        <input type="submit" class="btn btn-success" name="submit" value="Сохранить">
                    </form>
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
    <script src="{{ config('voyager.assets_path') }}/lib/js/tinymce/tinymce.min.js"></script>
    <!-- <script src="{{ config('voyager.assets_path') }}/js/voyager_tinymce.js"></script> -->
    <script type="text/javascript">
        function setImageValue(url){
  $('.mce-btn.mce-open').parent().find('.mce-textbox').val(url);
}

$(document).ready(function(){

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  tinymce.init({
    menubar: false,
    selector:'textarea.richTextBox',
    skin: 'voyager',
    min_height: 600,
    resize: 'vertical',
    plugins: "advlist,anchor,autolink,autoresize,bbcode,charmap,code,colorpicker,contextmenu,directionality,example,example_dependency,hr,image,insertdatetime,layer,legacyoutput,link,lists,nonbreaking,noneditable,pagebreak,paste,preview,searchreplace,spellchecker,tabfocus,table,textcolor,textpattern,visualblocks,visualchars,wordcount,youtube,giphy",
    extended_valid_elements : 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick],video[controls|preload|width|height|data-setup],source[src|type],iframe[frameborder|src|width|height|name|align],div[*],p[*],object[width|height|classid|codebase|embed|param]',
    file_browser_callback: function(field_name, url, type, win) {
            if(type =='image'){
              $('#upload_file').trigger('click');
            }
        },
    media_strict: false,
    toolbar: 'styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image youtube giphy | code table',
    convert_urls: true,
    image_caption: true,
    image_title: true,
    media_live_embeds: true,
    video_template_callback: function(data) {
       return '<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' + '<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' + (data.source2 ? '<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') + '</video>';
     }
  });

});

    </script>
@stop