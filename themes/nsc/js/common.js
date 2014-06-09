//$(document).ready(function() {

    function addBlock () {
        $('.alert').remove();
        $.ajax({
            type: 'post',
            url: '/admin/blocks/addblock',
            dataType: 'json',
            data: $('#addblock-form').serialize(),
            beforeSend: function() {

            },
            complete: function() {

            },

            success: function(data) {
                if (data.error) {
                    $('.modal-body').prepend('<div class="alert alert-danger"> <a class="close" data-dismiss="alert" href="#">&times;</a> Ошибка</div>');
                }
                if (data.success) {
                    $('#title-block-modal').modal('hide');
                    $('#blocks-list').append('<div id="block-'+data.id+'">'+data.numb_block+'</div>');

                }

            }
        });
    }
//});