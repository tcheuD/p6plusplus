
//initMainPic();

function initMainPic() {
    var selectMainPic = document.getElementById("edit_trick_form_mainPicture");
    $('#main-pic').attr("src", selectMainPic.options[0].getAttribute('data-img-src'));
}

$('#edit-main-picture').click(function (e) {
    e.preventDefault();

    var formImgContainer = document.getElementById("form_image_container");
    formImgContainer.innerHTML = '';

    var x = document.getElementById("edit_trick_form_mainPicture");
    var txt = "";
    var i;
    for (i = 0; i < x.length; i++) {

        var div = document.createElement('div');
        div.setAttribute('class', 'form_image');

        var label = document.createElement('label');
        label.setAttribute('for', x.options[i].value);

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
    if ($("#edit_trick_form_mainPicture").data('picker'))  {
        console.log($("#edit_trick_form_mainPicture").data('picker'));
        $("#edit_trick_form_mainPicture").data('picker').remove();
    }

    $("#edit_trick_form_mainPicture").imagepicker();

}