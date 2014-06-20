<div class="container">
    <? if (isset($message['type'])) {?>
        <div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
    <? } ?>
    <h1 class="page-header">Квартиры<small> / Новая квартира</small></h1>
	<ol class="breadcrumb">
		<li><a href="/admin/blocks#block-<?=$block->id?>"><?=$object->title_object?>, <?=$block->numb_block?></a></li>
		<li><a href="/admin/flats?block_id=<?=$flat['block_id'];?>">Квартиры</a></li>
		<li>Новая квартира</li>
	</ol>
    <?php echo form_open_multipart("/admin/flats/add?block_id=".$_GET['block_id']."", 'name="add" method="POST"');?>
	<div class="row">
		<div class="col-md-4">

			<div class="form-group">
				<label for="numb_flat" class="control-label">Номер</label>
				<input type="text" class="form-control" id="numb_flat" name="numb_flat" value="<?=$this->input->post('numb_flat')?>" placeholder="" >
			</div>
            <div class="form-group">
				<label for="full_area" class="control-label">Общая площадь</label>
				<input type="text" class="form-control" id="full_area" name="full_area" value="<?=$this->input->post('full_area')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="living_area" class="control-label">Жилая площадь</label>
				<input type="text" class="form-control" id="living_area" name="living_area" value="<?=$this->input->post('living_area')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="kitchen_area" class="control-label">Площадь кухни</label>
				<input type="text" class="form-control" id="kitchen_area" name="kitchen_area" value="<?=$this->input->post('kitchen_area')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="floor" class="control-label">Этаж</label>
				<input type="text" class="form-control" id="floor" name="floor" value="<?=$this->input->post('floor')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="count_room" class="control-label">Количество комнат</label>
				<input type="text" class="form-control" id="count_room" name="count_room" value="<?=$this->input->post('count_room')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Статус</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="price" class="control-label">Основная цена</label>
				<input type="text" class="form-control" id="price" name="price" value="<?=$this->input->post('price')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="sale_price" class="control-label">Акционная цена</label>
				<input type="text" class="form-control" id="sale_price" name="sale_price" value="<?=$this->input->post('sale_price')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="wc_type" class="control-label">Тип санузла</label>
				<input type="text" class="form-control" id="wc_type" name="wc_type" value="<?=$this->input->post('wc_type')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="balcon" class="control-label">Балкон</label>
				<input type="text" class="form-control" id="balcon" name="balcon" value="<?=$this->input->post('balcon')?>" placeholder="" >
			</div>
			<div class="form-group">
				<label for="loggia" class="control-label">Лоджия</label>
				<input type="text" class="form-control" id="loggia" name="loggia" value="<?=$this->input->post('loggia')?>" placeholder="" >
			</div>



		</div>
		<div class="col-md-8">

			<div class="form-group">
				<label for="status" class="control-label">Статус</label>
				<select class="form-control" name="status" id="typeSelect">
					<option value="1" <?=($this->input->post('status')=='1')?'selected':''?>>Доступно</option>
					<option value="2" <?=($this->input->post('status')=='2')?'selected':''?>>Резерв</option>
				</select>
			</div>

			<div class="form-group">
				<label for="thumb" class="control-label">Картинка малая</label>
				<div class="row">
					<div class="col-md-4">
                    <? if ($thumb) {?>
						<div><img src="<?=$thumb?>" class="img-thumbnail" alt=""></div>
						<div class="checkbox"><label><input type="checkbox" id="del_thumb"  value="1" name="del_thumb" >Удалить</label></div>
                    <? } ?>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<input type="file" id="thumb" name="thumb">
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="img" class="control-label">Картинка большая</label>
				<div class="row">
					<div class="col-md-6">
                        <? if ($img) {?>
						<div><img src="<?=$img?>" class="img-thumbnail" alt=""></div>
						<div class="checkbox"><label><input type="checkbox" id="del_img"  value="1" name="del_img">Удалить</label></div>
                        <? } ?>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="file" id="img" name="img" >
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="col-md-12">
			<button type="submit" class="btn btn-success" style="float: left;">Сохранить</button>
			<!--button type="submit" class="btn btn-warning btn-sm" style="float: right;" id="" onclick="trash('');">Удалить</button-->
		</div>
		
	</div>



    <?php echo form_close();?>
    
    
</div>
