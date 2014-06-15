<div class="container">
    
    <h1 class="page-header">Квартиры<small> / Квартира 22</small></h1>
    
    
	<ol class="breadcrumb">
		<li><a href="/admin/">Брусничное</a></li>
		<li><a href="/admin/">Корпус 1</a></li>
		<li><a href="/admin/">Квартиры</a></li>
		<li>Квартира 22</li>
	</ol>
    
    
    <?php echo form_open("", 'name="edit" method="POST"');?>


	
	<div class="row">
		<div class="col-md-4">

			<div class="form-group">
				<label for="xxx" class="control-label">Номер</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Общая площадь</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Жилая площадь</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Площадь кухни</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Этаж</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Количество комнат</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Статус</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Основная цена</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Акционная цена</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Тип санузла</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Балкон</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
			<div class="form-group">
				<label for="xxx" class="control-label">Лоджия</label>
				<input type="text" class="form-control" id="xxx" name="xxx" value="" placeholder="" >
			</div>
	       
			
		
		</div>
		<div class="col-md-8">
			
			<div class="form-group">
				<label for="xxx" class="control-label">Статус</label>
				<select class="form-control" name="typeSelect" id="typeSelect">
					<option value="0">Доступно</option>
					<option value="1">Резерв</option>
				</select>
			</div>
			
			<div class="form-group">
				<label for="xxx" class="control-label">Картинка малая</label>
				<div class="row">
					<div class="col-md-4">
						
						<div><img src="/public/layout/flats/22-a.png" class="img-thumbnail" alt=""></div>
						<div class="checkbox"><label><input type="checkbox" id="enabled"  value="1" name="enabled" checked > Удалить</label></div>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<input type="file" id="exampleInputFile">
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="xxx" class="control-label">Картинка большая</label>
				<div class="row">
					<div class="col-md-6">
						
						<div><img src="/public/layout/flats/22-b.png" class="img-thumbnail" alt=""></div>
						<div class="checkbox"><label><input type="checkbox" id="enabled"  value="1" name="enabled" checked > Удалить</label></div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="file" id="exampleInputFile">
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="col-md-12">
			<button type="submit" class="btn btn-success" style="float: left;">Сохранить</button>
			<button type="submit" class="btn btn-warning btn-sm" style="float: right;" id="" onclick="trash('');">Удалить</button>
		</div>
		
	</div>



    <?php echo form_close();?>
    
    
</div>
