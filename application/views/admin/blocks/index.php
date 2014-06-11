<div class="container">
    <? if (isset($message['type'])) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
	<h1 class="page-header">Объекты</h1>
	<div class="row">
        <form id="addblock-form" action="" method="post">
			<div class="col-md-9 col-md-push-3" style="margin-bottom: 10px">
				<a class="btn btn-default" href="#" data-toggle="modal" data-target="#title-block-modal">Добавить корпус</a>
			</div>
			<div class="col-md-3 col-md-pull-9" style="margin-bottom: 10px">
				<select class="form-control" name="object_id">
<?
foreach ($objects_list as $object)
{
?>
    				<option value="<?=$object['id']?>"><?=$object['title_object']?></option>
<?
}
?>
				</select>
			</div>
			<div class="modal fade" id="title-block-modal" tabindex="-1" role="dialog">
	            <div class="modal-dialog">
	                <div class="modal-content">
	                    <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
	                        <h4 class="modal-title" id="myModalLabel">Введите название корпуса</h4>
	                    </div>
	                    <div class="modal-body">
	
	                        <input type="text" name="numb_block" value="">
	                    </div>
	                    <div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
	                        <button class="btn btn-primary" id="submit_block" onclick="addBlock()" type="button">Сохранить изменения</button></div>
	                </div>
	            </div>
	        </div>
        </form>
	</div>
    <div class="row">
	    <div class="col-md-12">
	    	<h3 class="pull-left">Корпус 1</h3>
			<ul class="nav nav-pills pull-right">
			  <li>
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			      <span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Добавить этаж
			    </a>
			  </li>
			  <li>
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			      <span class="glyphicon glyphicon-list" style="color: #777"></span>&nbsp;&nbsp;Список квартир
			    </a>
			  </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="list-group" id="blocks-list">
<?
if (!empty($blocks_list))
foreach ($blocks_list as $block)
{
?>
    			<li id="block-<?=$block['id']?>" class="list-group-item"><a href=""><?=$block['numb_block']?></a></li>
<?
}
?>
            </ul>
		</div>
	</div>
	    <div class="row">
	    <div class="col-md-12">
	    	<h3 class="pull-left">Корпус 2</h3>
			<ul class="nav nav-pills pull-right">
			  <li>
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			      <span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Добавить этаж
			    </a>
			  </li>
			  <li>
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			      <span class="glyphicon glyphicon-list" style="color: #777"></span>&nbsp;&nbsp;Список квартир
			    </a>
			  </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="list-group" id="blocks-list">
<?
if (!empty($blocks_list))
foreach ($blocks_list as $block)
{
?>
    			<li id="block-<?=$block['id']?>" class="list-group-item"><a href=""><?=$block['numb_block']?></a></li>
<?
}
?>
            </ul>
		</div>
	</div>
</div>
