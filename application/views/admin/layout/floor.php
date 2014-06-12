<div class="container">

<h1 class="page-header">Брусничное<small> / корпус 1 - 1 этаж</small></h1>



<div class="row">
	<div class="col-md-12">
		<h3>Загрузить план этажа</h3>
		<div class="form-group">
			<input type="file" id="exampleInputFile">
		</div>
		<button type="submit" class="btn btn-success">Загрузить</button>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		После того как отметите квартиру на плане этажа, введите ее номер и сохраните отметку
		<form role="form" class="form-inline" style="margin-top: 20px">
		  <div class="form-group">
		    <input type="asdasd" class="form-control" id="exampleInputEmail1" value="Введите номер квартиры">
		  </div>
		  <button type="submit" class="btn btn-success">Сохранить</button>
		  <button type="submit" class="btn btn-default">Очистить</button>
		</form>
		<ul class="nav nav-pills pull-right">
			<li>
				<a class="dropdown-toggle" data-toggle="modal" data-target="#floor-block-modal" onclick="$('#addfloor-form #block_id').val('15')" href="#" >
					<span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Отметить квартиру
				</a>
			</li>
			<li>
				<a class="dropdown-toggle" data-toggle="modal" data-target="#floor-block-modal" onclick="$('#addfloor-form #block_id').val('15')" href="#" >
					<span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Удалить план этажа
				</a>
			</li>
		</ul>
		<img src="/public/layout/floor.png" alt="Sample">
	</div>
</div>



<div class="row">
	<div class="col-md-12">
		<h3>Список отмеченных квартир этажа</h3>
		<ul class="list-group" id="floors-list">
			<li id="floor-36" class="list-group-item"><a href="///1">89</a><a class="pull-right" href="/admin/floor/delfloor?floor_id=36" >Удалить</a></li>
			<li id="floor-37" class="list-group-item"><a href="///2">55</a><a class="pull-right" href="/admin/floor/delfloor?floor_id=37" >Удалить</a></li>
			<li id="floor-38" class="list-group-item"><a href="///33">33</a><a class="pull-right" href="/admin/floor/delfloor?floor_id=38" >Удалить</a></li>
		</ul>
	</div>
</div>


</div>