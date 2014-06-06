<div class="container">
    <? if ($message) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
    <h1 class="page-header">Наполнение<small> / страницы</small></h1>
    <?php echo form_open("", 'name="edit" method="POST"');?>
		<div class="form-group <?php if (form_error('content')) echo 'has-error"'; ?>">
            <label for="description" class="control-label">Html-код страницы</label>
			<textarea rows="20" id="content" name="content" class="form-control" placeholder=""><? echo $page->content; ?></textarea>
		</div>
		<div class="form-group <?php if (form_error('h1')) echo 'has-error"'; ?>">
			<label for="h1" class="control-label">Название</label>

			<input type="text" class="form-control" id="h1" name="h1" value="<? echo htmlspecialchars($page->h1); ?>" placeholder="" >
		</div>
		<div class="form-group <?php if (form_error('alias')) echo 'has-error"'; ?>">
			<label for="alias" class="control-label">Адрес</label>
            <input type="text" class="form-control" id="alias" name="alias" value="<? echo $page->alias; ?>" placeholder="" >
		</div>
        <div class="form-group <?php if (form_error('type')) echo 'has-error"'; ?>">
            <input type="hidden" name="type" value="<?=$page->type;?>">
        </div>
        <div class="form-group <?php if (form_error('title')) echo 'has-error"'; ?>">
            <label for="title" class="control-label">SEO Title</label>
            <input type="text" class="form-control" id="title" value="<? echo $page->title; ?>" name="title" placeholder="">
        </div>
        <div class="form-group <?php if (form_error('meta_description')) echo 'has-error"'; ?>">
            <label for="meta_description" class="control-label">Meta Description</label>
            <input type="text" class="form-control" id="meta_description" value="<? echo $page->meta_description; ?>" name="meta_description" placeholder="">
        </div>
        <div class="form-group <?php if (form_error('meta_keywords')) echo 'has-error"'; ?>">
            <label for="meta_keywords" class="control-label">Meta Keywords</label>
            <input type="text" class="form-control" id="meta_keywords" value="<? echo $page->meta_keywords; ?>" name="meta_keywords" placeholder="">
        </div>
        <div class="checkbox">
            <label>  <input type="checkbox" id="enabled"  value="1" name="enabled" <? if ($page->enabled) echo 'checked'; ?> > Enabled</label>
        </div>
        <? if (!empty($id)) {?> <input type="hidden" name="id" value="<?=$id?>"><?} else {?><input type="hidden" name="action" value="add"><?}?>
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
                url: '/admin/content/delete',
                dataType: 'json',
                data: {id:id},
                complete: function() {

                },
                success: function(data, status) {
                    if (data.error) {
                        alert('Удалить запись не удалось');
                    }
                    if (data.success) {
                        location.replace('/admin/content');
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
