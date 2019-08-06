onResize = function () {

    var width = window.outerWidth;

    if (width < 840)
    {
        $("#content-trick").hide();
        if ($(".showTrickMedia").length) {

            if ($(".showTrickMedia").is(":hidden")) {
                $(".showTrickMedia").text("Voir les médias");
                $(".showTrickMediaContainer").show();
            }
        } else {

            var btnShowTrickMedia = document.createElement('button');
            btnShowTrickMedia.setAttribute('class', 'btn showTrickMedia');
            btnShowTrickMedia.append("Voir les médias");

            var btnShowTrickMediaContainer = document.createElement("div");
            btnShowTrickMediaContainer.setAttribute('class', 'showTrickMediaContainer');
            btnShowTrickMediaContainer.append(btnShowTrickMedia);


            $("#content-trick").after(btnShowTrickMediaContainer);

        }

    }
    else {
        $("#content-trick").show();
        $(".showTrickMediaContainer").hide();
    }

};

showMedia= function () {
    $(".showTrickMedia").click(function(e){
        e.preventDefault();

        if ($(".showTrickMedia")[0].firstChild.data == "Masquer les médias") {
            $("#content-trick").hide();
            $(".showTrickMedia").text("Voir les médias");
        }
        else {
            $("#content-trick").show();
            $(".showTrickMedia").text("Masquer les médias");
        }


    });
};

$(document).ready(onResize);
$(window).resize(onResize);

$(document).ready(showMedia);