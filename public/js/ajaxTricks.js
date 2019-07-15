$(document).ready(function(){

    // Load more data
    $('.load-more').click(function(e){
        e.preventDefault();
        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var rowperpage = 15;
        row = row + rowperpage;

        if(row <= allcount) {
            $("#row").val(row);

            $.ajax({
                url: "/ajax2",
                type: "POST",
                data: {row: row},
                beforeSend: function () {
                    $(".load-more").text("Loading...");
                },
                success: function (response) {

                    // Setting little delay while displaying new content
                    setTimeout(function () {
                        // appending posts after last post with class="post"
                        var newRow = document.createElement('div');
                        newRow.setAttribute('class', 'row');

                        response.forEach(function (data) {

                            var div = document.createElement('div');
                            div.setAttribute('class', "col-2 col-12-narrower");
                            var section = document.createElement('section');
                            var imgLink = document.createElement('a');
                            imgLink.setAttribute('href', "trick/" + data.slug + "/1");
                            var divImg = document.createElement('div');
                            divImg.setAttribute('class', "index_img image");
                            divImg.setAttribute('style', "background-image:url("+data.mainPicture+")");
                            var img = document.createElement('img');
                            img.setAttribute('src', data.mainPicture);
                            var header = document.createElement('header');
                            var h3 = document.createElement('h3');
                            var titleLink = document.createElement('a');
                            titleLink.setAttribute('href', "trick/"+ data.slug + "/1");
                            titleLink.textContent = data.title;


                            div.appendChild(section);
                            section.appendChild(imgLink);
                            imgLink.appendChild(divImg);
                            divImg.appendChild(img);

                            section.appendChild(header);
                            header.appendChild(titleLink);

                            var isAuthenticated = $('.js-user-rating').data('isAuthenticated');
                            if (isAuthenticated) {

                                var routeEditTrick = "/trick/edit/" + data.slug + "/";
                                var routeDeleteTrick = data.slug;

                                var divIcon = document.createElement('div');
                                divIcon.setAttribute('class', "icon-index");

                                var formEdit = document.createElement('form');
                                formEdit.setAttribute('action', "/trick/edit/" + data.slug + "/");

                                var btnEdit = document.createElement('button');
                                btnEdit.setAttribute('class', 'edit');
                                btnEdit.setAttribute('type', 'submit');

                                var iEdit = document.createElement('i');
                                iEdit.setAttribute('class', 'fas fa-pen');

                                var btnDelete = document.createElement('button');
                                btnDelete.setAttribute('class', 'btn delete delete-trick');
                                btnDelete.setAttribute('value', data.slug);

                                var iDelete = document.createElement('i');
                                iDelete.setAttribute('class', 'fas fa-trash-alt');

                              divIcon.appendChild(formEdit);
                              divIcon.appendChild(btnDelete);
                              formEdit.appendChild(btnEdit);
                              btnEdit.appendChild(iEdit);
                              btnDelete.appendChild(iDelete);
                              header.appendChild(divIcon);
                            }

                            newRow.appendChild(div);
                            $(".row:last").after(newRow);
                        });

                        var rowno = row + rowperpage;

                            document.getElementById("back-to-top").style.display = "block";

                        // checking row value is greater than allcount or not
                        if (rowno > allcount) {

                            // Change the text and background
                            $('.load-more').text("Voir moins");
                        } else {
                            $(".load-more").text("Voir plus");
                        }
                    }, 500);
                },
            });
        }else{
            $('.load-more').text("Chargement...");

            // Setting little delay while removing contents
            setTimeout(function() {

                // When row is greater than allcount then remove all class='post' element after 3 element
                $('.row:nth-child(3)').nextAll('.row').remove();

                // Reset the value of row
                $("#row").val(0);

                // Change the text and background
                $('.load-more').text("Voir plus");
                document.getElementById("back-to-top").style.display = "none";
            }, 2000);


        }

    });

    $("#back-to-top").click(function () {
    });

});