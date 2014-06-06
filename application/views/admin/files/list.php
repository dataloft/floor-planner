<div class="container">
	<h1 class="page-header">Файлы</h1>
    <? if ($message) {?>
        <div class="alert alert-<?=$message['msg_type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['msg_type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
    <? } ?>
	<ol class="breadcrumb">
       <?
            $pathSize = count($path);
            foreach ($path as $value) {
        ?>
            <li><a href="/admin/files/<?=$value['url'];?>"><?=$value['text'];?></a></li>
       <?}?>
	</ol>
	<div class="row">
		<!--div class="col-md-12" style="margin-top: 20px">
			<ul class="nav nav-pills pull-right">
				<li><span class="glyphicon glyphicon-folder-open" style="color: #777"></span>&nbsp;&nbsp;<a href="?mkdir" class="add">Выделить все</a></li>
				<li><span class="glyphicon glyphicon-folder-open" style="color: #777"></span>&nbsp;&nbsp;<a href="?mkdir" class="add">Удалить</a></li>
			</ul>
		</div>
		
		
		<div class="btn-group pull-right">
		  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-folder-open" style="color: #777"></span>&nbsp;&nbsp;<a href="?mkdir" class="add">Выделить все</a></button>
		  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-folder-open" style="color: #777"></span>&nbsp;&nbsp;<a href="?mkdir" class="add">Удалить</a></button>
		</div-->


<div class="col-md-12" style="margin: 0 0 20px">
<ul class="nav nav-pills pull-right">
  <li>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      <span class="glyphicon glyphicon-ok" style="color: #777"></span>&nbsp;&nbsp;Выделить все
    </a>
  </li>
  <li>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      <span class="glyphicon glyphicon glyphicon-trash" style="color: #777"></span>&nbsp;&nbsp;Удалить
    </a>
  </li>
</ul>
</div>



	</div>
	
	
	<div class="row">
		<div class="col-md-12">
			<ul class="list-group">
                <?php foreach ($result as $i => $row): ?>
                    <?php if ($row['type'] == 'up'): ?>
                       <!-- <li class="list-group-item"><a href="<?php /*echo $row['url']; */?>"><?php /*echo $row['label']; */?></a></li>-->
                    <? else: ?>
                    <?php if ($row['type'] == 'dir'): ?>
                        <li class="list-group-item">
                        	<input type="checkbox">&nbsp;&nbsp;
                            <span class="glyphicon glyphicon-folder-open" style="color: #777; margin-right: 10px;"></span>
                            <a href="<?php echo $row['url']; ?>"><?php echo $row['label']; ?></a>
                        </li>
                    <?php else: ?>
                        <li class="list-group-item"><input type="checkbox">&nbsp;&nbsp;<a href="" style="color: #555"><?php echo $row['label']; ?></a></li>
                <?php endif; ?>
                <?php endif; ?>
                <?php endforeach; ?>
			</ul>
		</div>
		
		

<!--div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">
  <h4 class="panel-title">
    <a href="#collapseOne" data-toggle="collapse">Действия</a>
  </h4>
</div>
<div id="collapseOne" class="panel-collapse collapse in">
  <div class="panel-body"-->
    
    


<div class="col-md-12" style="margin-top: 20px">


<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#upload" data-toggle="tab">Загрузка файлов</a></li>
  <li><a href="#mkdir" data-toggle="tab">Создать папку</a></li>
  <li><a href="#renamedir" data-toggle="tab">Переименовать папку</a></li>
  <!--li><a href="#multiupload" data-toggle="tab">Мультизагрузка</a></li-->
</ul>

<!-- Tab panes -->

<div class="tab-content">
  
  
  <div class="tab-pane fade in active" id="upload">
	  
	  

<!--form role="form" style="margin-top: 20px">
  <div class="form-group">
    <input type="file" id="exampleInputFile">
    <input type="file" id="exampleInputFile">
    <input type="file" id="exampleInputFile">
  </div>
  <div class="form-group">
  	<button type="button" class="btn btn-default btn-xs">Добавить еще файлы</button>
  </div>
  <button type="submit" class="btn btn-success">Загрузить</button>
</form-->	  
	  
	  
	  
  </div>




  <div class="tab-pane fade" id="mkdir">
	  
	  
	  
<form role="form" class="form-inline" style="margin-top: 20px">
  <div class="form-group">
    <input type="asdasd" class="form-control" id="exampleInputEmail1" placeholder="Название папки">
  </div>
  <button type="submit" class="btn btn-success">Создать</button>
</form>


	  
	  
	  
  </div>
  
  
  <div class="tab-pane fade" id="renamedir">


<form role="form" class="form-inline" style="margin-top: 20px">
  <div class="form-group">
    <input type="asdasd" class="form-control" id="exampleInputEmail1" value="<?= $path[$pathSize-1]['text'];?>">
  </div>
  <button type="submit" class="btn btn-success">Переименовать</button>
</form>

	  
	  
	  
  </div>

</div>

    
    
    
    
</div>    
    
  <!--/div>
</div>
</div>
</div-->
	

		
		
	</div>
	
	

	
</div>
