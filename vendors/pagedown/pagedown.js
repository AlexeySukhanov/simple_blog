

$(document).ready(function(){
    if($('div').is('#wmd-preview')){

        (function(){
            //alert('lol');
            var converter = new Markdown.Converter();
            var editor = new Markdown.Editor(converter);
            editor.run();
        }());

        alert('lol');


        $('#createEnty').submit(function(){
            var content = $('#wmd-preview').html();
            $('#hcontent').val(content);
            alert('hcontent: ' + $('#hcontent').val());
        });
    }

});