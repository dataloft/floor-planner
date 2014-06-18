<div class="container">
    <? if (isset($message['type'])) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
	<h1 class="page-header">Квартиры</h1>
	<div class="row">
		<div class="col-md-12">
			<ul class="list-group" id="flat-list">
<?
if (!empty($flats_list))
foreach ($flats_list as $flat)
{
?>
    			<li id="" class="list-group-item"><a href=""><?=$flat['numb_flat']?></a></li>
<?
}
?>
            </ul>
		</div>
	</div>
    <div class="row">
    	<div class="col-md-12">
	        <form action="/admin/flats/addflat?block_id=<?=$_GET['block_id']?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	        <div class="form-group">
	            <input type="file" name="csv-flat" size="20" />
	        </div>
	        <div class="form-group">
	            <input type="submit" class="btn btn-success" value="Загрузить" name="upload">
	        </div>
	        </form>
	    </div>
    </div>
</div>
