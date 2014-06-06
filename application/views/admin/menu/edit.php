<div class="container">
    <? if ($message) {?>
        <div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
    <? } ?>
    <h1 class="page-header">Меню<small> / редактирование</small></h1>
    <?php echo form_open("", 'name="edit" method="POST"');?>
    <div class="form-group <?php if (form_error('name')) echo 'has-error"'; ?>">
        <label for="name" class="control-label">Название пункта меню</label>
        <input type="text" class="form-control" id="name" name="name" value="<? echo $menu->name; ?>" placeholder="" >
    </div>
    <div class="form-group <?php if (form_error('url')) echo 'has-error"'; ?>">
        <label for="url" class="control-label">Ссылка</label>

        <input type="text" class="form-control" id="url" name="url" value="<? echo $menu->url; ?>" placeholder="" >
    </div>
    <div class="form-group <?php if (form_error('order')) echo 'has-error"'; ?>">
        <label for="order" class="control-label">Номер пункта меню</label>

        <input type="text" class="form-control" id="order" name="order" value="<? echo $menu->order; ?>" placeholder="" size="4">
    </div>
    <div class="form-group <?php if (form_error('level_menu')) echo 'has-error"'; ?>">
        <label for="level_menu" class="control-label">Родительский раздел</label>
        <select class="form-control" name="level_menu">
            <option value="0"></option>
          <?
          echo $lvl_menu;
          ?>
        </select>

    </div>
    <?
     if (!empty($id)) {?> <input type="hidden" name="id" value="<?=$id?>"><?} else {?><input type="hidden" name="action" value="add"><?}?>
    <button type="submit" class="btn btn-success" style="float: left;">Сохранить</button>
    <?php echo form_close();?>
    <? if (!empty($id)) {?><button type="submit" class="btn btn-warning btn-sm" style="float: right;" id="<?=$id?>" onclick="trash('<?=$id?>');">Удалить</button><?}?>
</div>

<script type="text/javascript"><!--
    function trash (id) {
        //var li = $('#'+id).parent();
        //var tr = td.parent();
        if (confirm('Удалить запись?')) {
            $.ajax({
                type: 'post',
                url: '/admin/menu/delete',
                dataType: 'json',
                data: {id:id},
                complete: function() {
                    $("#pos_save").removeAttr("disable");
                },
                success: function(data, status) {
                    if (data.error) {
                        alert('Удалить запись не удалось');
                    }
                    if (data.success) {
                        location.replace('/admin/menu');
                        /* alert('Удалить запись удалось');
                         //change the background color to red before removing
                         li.css("background-color","#FF3700");
                         li.fadeOut(400, function(){
                         li.remove();*/
                        //  });

                    }

                },
                error: function (data,status, error)
                {
                    alert(error);
                }
            });
        }
    }

    //--></script>
