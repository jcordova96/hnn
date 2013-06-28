

$(document).ready(function() {


    $('.more-uploads-button').click(function(){
        $('.image-inputs').append("<input name='Article[file][]' type='file' /><br />");
    });

    $('.more-remote-images-button').click(function(){
        $('.image-inputs').append("<input name='Article[remote_images][]' type='text' /><br />");
    });




});
