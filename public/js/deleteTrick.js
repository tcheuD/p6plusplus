$(document).on('click', '.delete-trick', function (e) {

    e.preventDefault();

        var slug = $(this).val();
        console.log(slug);

        $.confirm({
            title: 'Confirmation',
            content: 'Voulez-vous vraiment supprimer cette figure ?',
            buttons: {
                confirm: {
                    text: 'Supprimer',
                    btnClass: 'btn-dark',
                    action: function () {
                        $.ajax({
                            url: "/ajax3",
                            type: "POST",
                            data: {slug: slug},
                            success: function () {
                                $.alert('La figure a bien été supprimée');
                                $(location).attr('href', '/')
                            },
                        });
                    }
                },
                cancelAction: {
                    text: 'Annuler',
                    btnClass: 'btn-dark',
                    action: function () {
                    }
                }
            }
        });
});