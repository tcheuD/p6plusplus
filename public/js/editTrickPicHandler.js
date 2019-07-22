$('.collection-pictures').collection({
    'add': '<li class="no_list_li"><a href="#" class="btn btn-default button btn_media_edit_trick">Ajouter une photo</a></li>',
    'add_at_the_end': true
});
$('.collection-videos').collection({
    'add': '<li class="no_list_li"><a href="#" class="btn btn-default button btn_media_edit_trick">Ajouter une vidéo</a></li>',
    'add_at_the_end': true
    //preserve_names: false
});




function on() {
    document.getElementById("form_image").style.display = "block";
}

function off() {
    document.getElementById("form_image").style.display = "none";
}

$(document).on('click', '.mainPicturePicker', function (e) {

    var picChoice = $(this)[0].getAttribute('pic-position');
    $("#edit_trick_form_mainPicture").val(parseInt(picChoice));

    var img = $('#main-pic').attr("src", $(this)[0].src);
});

$(document).on('click', '.edit_trick_form_pictures-collection-remove', function (e) {
    var parentDivId = $(this).parent().parent().parent().parent().attr('id');
    var patt1 = /\d/g;
    var result = parentDivId.match(patt1);
    console.log(result[0]);

    var selectMainPic = document.getElementById("edit_trick_form_mainPicture");

    if (selectMainPic.options[result[0]] == selectMainPic.selectedOptions[0])
    {
        selectMainPic.options[result[0]] = null;
        $('#main-pic').attr("src", selectMainPic.options[0].getAttribute('data-img-src'));

    } else { selectMainPic.options[result[0]] = null; }

});

$('.delete-main-picture').click(function (e) {
    e.preventDefault();
    var selectMainPic = document.getElementById("edit_trick_form_mainPicture");
    selectMainPic.selectedOptions[0].remove();

    $('#main-pic').attr("src", selectMainPic.options[0].getAttribute('data-img-src'));
});
