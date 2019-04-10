$(document).on('change', '.pic', function()
{
    var file_data = $(this).prop('files')[0];
    var reader = new FileReader();
    var div = $(this).parents();

    reader.addEventListener('load', function (event)
    {
        div[2].children[0].src = reader.result;
    }, false);

    if (file_data)
    {
        reader.readAsDataURL(file_data);

        var picId = div[2].children[0].id;
        var data = new FormData();
        data.append('file', file_data);
        data.append('picId', picId);

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
            $( '#pic' ).text(data.pic);
            div[2].children[0].src = "/images/"+data;

            var position =  div[2].children[2].id;
            var numbers = position.match(/\d+/g).map(Number); // return the pic's position
            var numbers = numbers[0];
            var picFieldInMainPicture = $('.save option[value="'+ [numbers] +'"]');

            if (picFieldInMainPicture[0]) {
                picFieldInMainPicture[0].innerHTML = data;
            } else {
                var lastSelectOptionValue = $('#edit_trick_form_mainPicture option:last-child').val();
                lastSelectOptionValue = parseInt(lastSelectOptionValue);
                var newSelectOptionValue = lastSelectOptionValue + 1;

                $('.save').append('<option value="'+ newSelectOptionValue +'">'+data+'</option>');
            }
        }
    })
});

$('#edit_trick_form_mainPicture').on('change', function(){

    var url = $(this).children("option:selected").text();
    var img = $('#main-pic').attr("src", "/images/"+url);

});
