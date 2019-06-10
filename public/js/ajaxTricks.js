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
                            imgLink.setAttribute('class', 'image featured');
                            var img = document.createElement('img');
                            img.setAttribute('src', data.mainPicture);
                            var header = document.createElement('header');
                            var h3 = document.createElement('h3');
                            var titleLink = document.createElement('a');
                            titleLink.setAttribute('href', "trick/"+ data.slug + "/1");
                            titleLink.textContent = data.title;


                            div.appendChild(section);
                            section.appendChild(imgLink);
                            imgLink.appendChild(img);

                            div.appendChild(header);
                            header.appendChild(h3);
                            h3.appendChild(titleLink);

                            var isAuthenticated = $('.js-user-rating').data('isAuthenticated');
                            if (isAuthenticated) {
                                var routeEditTrick = "/trick/edit/" + data.slug + "/";
                                var routeDeleteTrick = data.slug;
                                //routeEditTrick = routeEditTrick.replace('trick_slug', data.slug);
                                //routeDeleteTrick = routeDeleteTrick.replace('trick_slug', data.slug);

                                var editTrickLink = document.createElement('a');
                                editTrickLink.setAttribute('href', routeEditTrick);
                                editTrickLink.textContent = "Modifier";

                                var deleteTrickLink = document.createElement('button');
                                deleteTrickLink.setAttribute('value', routeDeleteTrick);
                                deleteTrickLink.setAttribute('class', 'delete');
                                deleteTrickLink.textContent = "Supprimer";

                                header.appendChild(editTrickLink);
                                header.appendChild(deleteTrickLink);
                            }

                            newRow.appendChild(div);
                            $(".row:last").after(newRow);
                        });

                        var rowno = row + rowperpage;

                        // checking row value is greater than allcount or not
                        if (rowno > allcount) {

                            // Change the text and background
                            $('.load-more').text("Hide");
                            $('.load-more').css("background", "darkorchid");
                        } else {
                            $(".load-more").text("Load more");
                        }
                    }, 500);
                },
            });
        }else{
            $('.load-more').text("Loading...");

            // Setting little delay while removing contents
            setTimeout(function() {

                // When row is greater than allcount then remove all class='post' element after 3 element
                $('.row:nth-child(3)').nextAll('.row').remove();

                // Reset the value of row
                $("#row").val(0);

                // Change the text and background
                $('.load-more').text("Load more");
                $('.load-more').css("background","#15a9ce");

            }, 2000);


        }

    });

});