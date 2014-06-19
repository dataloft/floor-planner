<div class="container">
    <? if (isset($message['type'])) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
	<h1 class="page-header">Квартиры</h1>

    <ol class="breadcrumb">
        <li><a href="/admin/blocks#block-<?=$block->id?>"><?=$object->title_object?>, <?=$block->numb_block?></a></li>
        <li>Квартиры</li>
    </ol>
	
	
	<div class="row">
		<div class="col-md-12">
			<ul class="list-group" id="flat-list">
<?
if (!empty($flats_list))
foreach ($flats_list as $flat)
{
?>
    			<li id="" class="list-group-item"><a href="/admin/flats/<?=$flat['id']?>"><?=$flat['numb_flat']?></a><a class="pull-right" href="/admin/flats/deleteflat?id=<?=$flat['id']?>" >Удалить</a></li>
<?
}
?>
            </ul>
		</div>
	</div>
    <div class="row">
    	<div class="col-md-12" style="margin-top: 30px">
	        <form action="/admin/flats/addflat?block_id=<?=$_GET['block_id']?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	        <div class="form-group">
	        	<label for="csv-flat">Прокачка csv</label>
	            <input type="file" name="csv-flat" size="20" />
	            <p class="help-block">Вы можете обновить список квартир целиком, прокачав CSV файл.<br>Прокачка файлов удалит текущий список квартир корпуса и заменит его на новый.</p>
	        </div>
	        <div class="form-group">
	            <input type="submit" class="btn btn-success" value="Загрузить и обработать" name="upload">
	        </div>
	        </form>
	    </div>
    </div>
</div>
