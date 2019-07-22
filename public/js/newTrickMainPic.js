
//initMainPic();

function initMainPic() {
    var selectMainPic = document.getElementById("trick_form_mainPicture");
    $('#main-pic').attr("src", selectMainPic.options[0].getAttribute('data-img-src'));
}


$(document).on('change', '#trick_form_mainPicture', function(e) {
    var selectMainPic = document.getElementById("trick_form_mainPicture");
    console.log(selectMainPic.selectedOptions[0]);
});

$('#edit-main-picture').click(function (e) {
    e.preventDefault();
    // on();
    /**$('#edit_trick_form_mainPicture').each(function(key) {
                    var selected = $(this);
                    console.log(key)
                }); **/


    var formImgContainer = document.getElementById("form_image_container");
    formImgContainer.innerHTML = '';

    var x = document.getElementById("trick_form_mainPicture");
    var txt = "";
    var i;
    for (i = 0; i < x.length; i++) {

        var div = document.createElement('div');
        div.setAttribute('class', 'form_image');

        var label = document.createElement('label');
        label.setAttribute('for', x.options[i].value);

        //var img = '<img src="'+ x.options[i].getAttribute('data-img-src') +'" alt="snowtrick" style="width:250px; height:150px" class="mainPicturePicker" />';
        var img = document.createElement('img');
        img.setAttribute('src', x.options[i].getAttribute('data-img-src'));
        img.setAttribute('style', 'width:250px; height:150px');
        img.setAttribute('class', 'mainPicturePicker');
        img.setAttribute('pic-position', i);

        label.append(img);
        div.append(img);
        $('#form_image_container').append(div);

        txt = x.options[i];
        console.log(txt);
    }
    on();
});

function callImgPicker() {
    if ($("#trick_form_mainPicture").data('picker'))  {
        console.log($("#edit_trick_form_mainPicture").data('picker'));
        $("#trick_form_mainPicture").data('picker').remove();
    }

    $("#trick_form_mainPicture").imagepicker();

}