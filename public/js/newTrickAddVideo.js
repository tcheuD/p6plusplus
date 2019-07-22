$('.test-popup-link').magnificPopup({
    type: 'image'
    // other options
});

//$('.video-input').hide();

$(document).on('click', '.video-button', (function () {
    var inputId = $(this).attr('name');
    var input = $('#'+inputId);
    var divId = inputId.replace('_url', '');
    var iframe = '<div><iframe src="http://www.youtube.com/embed/' + youtube_parser(input.val()) + '?autoplay=0"frameborder="0" id="iframe_' + divId + '"></iframe></div>';
    var label = '<label for="'+ inputId +'" class="required video-label"><i class="fas fa-pen"></i></label>';
    var buttonRemove = '<button class="btn delete blabla" data="#'+ divId +'"><i class="fas fa-trash-alt"></i></button>';
    $('#'+divId).prepend(iframe + label + buttonRemove);
    input.attr('style', 'display:none;');
    $(this).remove();
}));

$(document).on('click', '.blabla', function (e) {
    e.preventDefault();
    $(this).parent().parent().remove();
});

$(document).on('click', '.video-label', (function (e) {
    e.preventDefault();

    var videoFullName = $(this).attr('for');
    var videoName = videoFullName.replace('_url', '');

    var input = $('#'+videoFullName);
    input.toggle();

    input.change(function () {
        var iframe = $('#iframe_'+videoName);
        iframe.attr('src', 'http://www.youtube.com/embed/'+youtube_parser(input.val())+'?autoplay=0"');
    });

}));

function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    return (match&&match[7].length==11)? match[7] : false;
}