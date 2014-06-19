<div class="container">
    <? if (is_array($message) and array_key_exists('type', $message)) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
	<h1 class="page-header">Объекты, корпуса, этажи</h1>
	<div class="row">
        <form id="addblock-form" action="/admin/blocks/addblock" method="post">
        <div class="col-md-9 col-md-push-3" style="margin-bottom: 10px">
            <a class="btn btn-default" href="#" data-toggle="modal" data-target="#title-block-modal">Добавить корпус</a>
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
                        <input type="submit" class="btn btn-primary" id="submit_block" value="Сохранить изменения"></div>
                </div>
            </div>
        </div>
            <input type="hidden" name="object_id" value="<?=$object_id?>">
       </form>
        <form id="object-form" action="" method="post">

			<div class="col-md-3 col-md-pull-9" style="margin-bottom: 10px">
				<select class="form-control" name="object_id"  onchange="this.form.submit();">
<?
foreach ($objects_list as $object)
{
?>
    				<option value="<?=$object['id']?>" <?=($object['id'] == $object_id)?'selected':''?>><?=$object['title_object']?></option>
<?
}
?>
				</select>
			</div>

        </form>
	</div>
    <div id="blocks-list">
        <?
        if (!empty($blocks_list))
            foreach ($blocks_list as $block)
            {
                ?>
                <div  id="block-<?=$block['id']?>">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="pull-left"><?=$block['numb_block']?></h3>
                            <ul class="nav nav-pills pull-right">
                                <li>
                                    <a class="dropdown-toggle" data-toggle="modal" data-target="#floor-block-modal" onclick="$('#addfloor-form #block_id').val('<?=$block['id']?>')" href="#" >
                                        <span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Добавить этаж
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-toggle" href="/admin/flats/?block_id=<?=$block['id']?>">
                                        <span class="glyphicon glyphicon-list" style="color: #777"></span>&nbsp;&nbsp;Список квартир
                                    </a>
                                </li>
                                <? if (empty($block['floors'])) {?>
                                <li>
                                    <a class="dropdown-toggle"  href="/admin/blocks/delblock?block_id=<?=$block['id']?>">
                                     Удалить
                                    </a>
                                </li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group" id="floors-list">
                                <?
                                if (!empty($block['floors']))
                                {
                                    foreach ($block['floors'] as $floor)
                                    {
                                        ?>
                                        <li id="floor-<?=$floor['id']?>" class="list-group-item"><a href="/admin/floor/<?=$floor['id']?>">Этаж <?=$floor['numb_floor']?></a><? if (empty($floor['plan'])) {?><a class="pull-right" href="/admin/floor/delfloor?floor_id=<?=$floor['id']?>" >Удалить</a><?}?></li>
                                    <?
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?
            }
            ?>
        <form action="/admin/floor/addfloor" id="addfloor-form" method="POST">
        <div class="modal fade" id="floor-block-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
                        <h4 class="modal-title" id="myModalLabel">Введите название Этажа</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text"  id="floor_name" name="floor_name" value="">
                        <input type="hidden"  id="block_id" name="block_id" value="">
                    </div>
                    <div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-primary" value="Сохранить изменения"></div>
                </div>
            </div>
        </div>
    </div>
</div>
