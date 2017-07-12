
(function($){
    $(function(){

        tinymce.init({
            selector: '.editor',
            language: 'ru',
            plugins : 'advlist autolink link image lists charmap media contextmenu visualblocks wordcount responsivefilemanager',
            toolbar: 'undo, redo | bold, italic, underline, strikethrough | alignleft, aligncenter, alignright, alignjustify | cut, copy, paste | bullist, numlist | subscript, superscript | removeformat | media, image, link | charmap | styleselect ',
            contextmenu: "link image inserttable | cell row column deletetable",
            contextmenu_never_use_native: true,
            image_advtab: true ,
            external_filemanager_path:"/filemanager/",
            filemanager_title:"Менеджер файлов" ,
            external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
            filemanager_access_key:"5NRQwwiMnq"
        });

    });
})(jQuery);

function button_size_add(url)
{
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            var div = document.createElement('div');
            div.innerHTML = ajax.responseText;
            var container = document.getElementById('container_size');
            container.appendChild(div);
        }
    }
    ajax.open('get', url, true);
    ajax.send();
}

function button_ingredient_add(url)
{
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            var div = document.createElement('div');
            div.innerHTML = ajax.responseText;
            var container = document.getElementById('container_ingredient');
            container.appendChild(div);
        }
    }
    ajax.open('get', url, true);
    ajax.send();
}