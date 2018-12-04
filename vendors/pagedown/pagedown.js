$(document).ready(function(){
    if($('div').is('#wmd-preview')){
        (function(){
            var converter = new Markdown.Converter();
            var editor = new Markdown.Editor(converter);
            editor.run();
        }());

        $('#createEnty').submit(function(){
            var content = $('#wmd-preview').html();
            $('#hcontent').val(content);
        });
    }
});