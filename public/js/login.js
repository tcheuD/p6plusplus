onResize = function () {

    var width = window.outerWidth;

    if (width < 840)
    {
        $(".link_register_on_login_page").show();
    }
    else {
        $(".link_register_on_login_page").hide();
    }


    console.log(width);

};

$(document).ready(onResize);
$(window).resize(onResize);