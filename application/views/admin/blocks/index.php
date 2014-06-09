<div class="container">
    <? if ($message) {?>
	<div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
	<? } ?>
    <form id="addblock-form" action="" method="post">
    <select name="object_id">
        <?
            foreach ($objects_list as $object)
            {
        ?>
                <option value="<?=$object['id']?>"><?=$object['title_object']?></option>
        <?
            }
        ?>
    </select>
        <a class="btn btn-lg btn-success"
           href="#" data-toggle="modal"
           data-target="#title-block-modal">Добавить корпус</a>
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
    <div id="blocks-list">
    <?
        if (!empty($blocks_list))
            foreach ($blocks_list as $block)
            {
            ?>
                <div id="block-<?=$block['id']?>"><?=$block['numb_block']?></div>
            <?
            }
            ?>
    </div>


</div>
