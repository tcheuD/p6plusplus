$(document).on('change', '.pic', function()
{
    var file_data = $(this).prop('files')[0];
    var reader = new FileReader();
    var div = $(this).parents();
    var trickSlug = $('.delete-trick').val();

    reader.addEventListener('load', function (event)
    {
        console.log(div[2].children[0].src );
        div[2].children[0].src = reader.result;
        div[2].children[0].classList.remove("hide");
        div[2].children[1].children[0].children[0].classList.remove("hide");
    }, false);

    if (file_data)
    {
        reader.readAsDataURL(file_data);

        var picId = div[2].children[0].id;
        var data = new FormData();
        data.append('file', file_data);
        data.append('picId', picId);
        data.append('trickSlug', trickSlug);

    }
    $.ajax({
        url:'/ajax',
        type: "POST",
        dataType: "json",
        data: data,
        contentType: false,
        processData: false,
        async: true,
        success: function (data)
        {
            console.log(data);

            $( '#pic' ).text(data.pic);
            div[2].children[0].src = "/images/"+data;

            var position =  div[2].children[1].id;
            var numbers = position.match(/\d+/g).map(Number); // return the pic's position
            var numbers = numbers[0];
            var picFieldInMainPicture = $('.save option[value="'+ [numbers] +'"]');

            if (picFieldInMainPicture[0]) {
                picFieldInMainPicture[0].innerHTML = data;
                picFieldInMainPicture[0].attributes[1].value = "/images/"+data;
            } else {
                if ($('#edit_trick_form_mainPicture').length) {
                    var lastSelectOptionValue = $('#edit_trick_form_mainPicture option:last-child').val();

                } else {
                    var lastSelectOptionValue = $('#trick_form_mainPicture option:last-child').val();
                }
                
                if (lastSelectOptionValue == null) {
                    lastSelectOptionValue = -1;
                }
                lastSelectOptionValue = parseInt(lastSelectOptionValue);
                var newSelectOptionValue = lastSelectOptionValue + 1;

                $('.save').append('<option value="'+ newSelectOptionValue +'" data-img-src="/images/'+data+'" data-img-class="test">'+data+'</option>');

                if ( newSelectOptionValue == 0) {
                    initMainPic();
                    $('#mainPictureContainer').show();
                }
            }
        }
    })
});

$('#edit_trick_form_mainPicture').on('change', function(){

    var url = $(this).children("option:selected").text();
    var img = $('#main-pic').attr("src", "/images/"+url);

});

$('#trick_form_mainPicture').on('change', function(){

    var url = $(this).children("option:selected").text();
    var img = $('#main-pic').attr("src", "/images/"+url);

});

$(document).on('change', '.input-pic-new', function()
{
    $(this).hide();
    //TODO: add edit icon
});
