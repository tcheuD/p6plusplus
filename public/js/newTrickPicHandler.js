$('.collection-pictures').collection({
    'add': '<a href="#" class="btn btn-default">Ajouter une photo</a>',
    'add_at_the_end': true
});
$('.collection-videos').collection({
    'add': '<a href="#" class="btn btn-default">Ajouter une vidéo</a>',
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
    $("#trick_form_mainPicture").val(parseInt(picChoice));

    var img = $('#main-pic').attr("src", $(this)[0].src);
});

$(document).on('click', '.trick_form_pictures-collection-remove', function (e) {
    var parentDivId = $(this).parent().parent().parent().parent().attr('id');
    var patt1 = /\d/g;
    var result = parentDivId.match(patt1);
    console.log(result[0]);

    var selectMainPic = document.getElementById("trick_form_mainPicture");

    if (selectMainPic.options[result[0]] == selectMainPic.selectedOptions[0])
    {
        selectMainPic.options[result[0]] = null;
        $('#main-pic').attr("src", selectMainPic.options[0].getAttribute('data-img-src'));

    } else { selectMainPic.options[result[0]] = null; }

});

$('.delete-main-picture').click(function (e) {
    e.preventDefault();
    var selectMainPic = document.getElementById("trick_form_mainPicture");
    selectMainPic.selectedOptions[0].remove();

    $('#main-pic').attr("src", selectMainPic.options[0].getAttribute('data-img-src'));
});

