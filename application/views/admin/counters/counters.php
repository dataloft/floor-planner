<div class="container">
    <? if ($message) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
    <h1 class="page-header">Счетчики</h1>
    <?php echo form_open("", 'name="edit" method="POST"');?>
		
		<div class="form-group <?php if (form_error('counters')) echo 'has-error"'; ?>">
            <label for="text" class="control-label">Код счетчиков</label>
			<textarea rows="20" id="text" name="text" class="form-control" placeholder=""><?=$counters->text?></textarea>
		</div>
		<div class="form-group <?php if (form_error('domain')) echo 'has-error"'; ?>">
			<label for="domains" class="control-label">Домены на которых будет выводиться код счетчиков</label>
			<input type="text" class="form-control" id="domain" name="domain" value="<?=$counters->domain?>" placeholder="" >
		</div>
		<div class="form-group <?php if (form_error('ip_restrict')) echo 'has-error"'; ?>">
			<label for="ip_restrict" class="control-label">Ограничение для IP</label>
            <input type="text" class="form-control" id="ip_restrict" name="ip" value="<?=$counters->ip?>" placeholder="" >
		</div>
              
		<button type="submit" class="btn btn-success" name="save" value="save" style="float: left;">Сохранить</button>

    <?php echo form_close();?>
</div>