onResize = function () {

    var width = window.outerWidth;

    if (width < 840)
    {
        $(".link_login_on_registration_page").show();
    }
    else {
        $(".link_login_on_registration_page").hide();
    }


};

$(document).ready(onResize);
$(window).resize(onResize);