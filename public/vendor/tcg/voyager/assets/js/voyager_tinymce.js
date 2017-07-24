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
