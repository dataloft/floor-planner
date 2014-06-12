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
                    $('#blocks-list').append('<div id="block-'+data.id+'"> ' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<h3 class="pull-left">'+data.numb_block+'</h3>' +
                        '<ul class="nav nav-pills pull-right">' +
                        '<li>' +
                        '<a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="addFloor('+data.id+')">' +
                        '<span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Добавить этаж' +
                        '</a>' +
                        '</li>' +
                        '<li>' +
                        '<a class="dropdown-toggle" data-toggle="dropdown" href="#">' +
                        '<span class="glyphicon glyphicon-list" style="color: #777"></span>&nbsp;&nbsp;Список квартир' +
                        '</a>'
                        +'<a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="delBlock('+data.id+')">' +
                        'Удалить' +
                        '</a>' +
                        '</li>' +
                        '</ul>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<ul class="list-group" id="floors-list">' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>');

                }

            }
        });
    }

    function addFloor (id) {

        $('.alert').remove();
        $.ajax({
            type: 'post',
            url: '/admin/floor/addfloor',
            dataType: 'json',
            data: {'block_id':id},
            beforeSend: function() {

            },
            complete: function() {

            },

            success: function(data) {

                if (data.error) {

                    $('.page-header').before('<div class="alert alert-danger"> <a class="close" data-dismiss="alert" href="#">&times;</a> Ошибка</div>');
                }
                if (data.success) {
                    $('.alert').remove();
                    $('#block-'+id+' #floors-list').append('<li id="floor-'+data.id+'" class="list-group-item"><a href="">'+data.numb_floor+'</a><a href="#" onclick="delFloor('+data.id+')">Удалить</a></li>');

                }

            }
        });
    }

    function delBlock (id) {
            $('.alert').remove();
            $.ajax({
                type: 'post',
                url: '/admin/blocks/delblock',
                dataType: 'json',
                data: {'block_id':id},
                beforeSend: function() {

                },
                complete: function() {

                },

                success: function(data) {

                    if (data.error) {

                        $('.page-header').before('<div class="alert alert-danger"> <a class="close" data-dismiss="alert" href="#">&times;</a> Ошибка</div>');
                    }
                    if (data.success) {
                        $('.alert').remove();
                        $('#block-'+id).remove();

                    }

                }
            });
    }
        function delFloor (id) {
                    $('.alert').remove();
                    $.ajax({
                        type: 'post',
                        url: '/admin/floor/delfloor',
                        dataType: 'json',
                        data: {'floor_id':id},
                        beforeSend: function() {

                        },
                        complete: function() {

                        },

                        success: function(data) {

                            if (data.error) {

                                $('.page-header').before('<div class="alert alert-danger"> <a class="close" data-dismiss="alert" href="#">&times;</a> Ошибка</div>');
                            }
                            if (data.success) {
                                $('.alert').remove();
                                $('#floor-'+id).remove();

                            }

                        }
                    });
    }
//});