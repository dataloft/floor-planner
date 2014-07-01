<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" style="margin-top: 65px;">
				<div class="panel-heading">
					<h3 class="panel-title">Вход в систему</h3>
				</div>
				<div class="panel-body">
                   <?
                    if ($message)
                    {
                    ?>
                    <div class="alert alert-danger"> <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <? echo $message; ?>
                    </div>
                    <?
                    }
                    ?>

					<?php echo form_open("admin/login", 'id="login" class="login" name="login" method="POST"');?>
					<fieldset>
						<div class="input-group" style="margin-bottom: 25px"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input class="form-control" value="<? echo set_value('identity'); ?>" placeholder="Имя или email" name="identity" type="text" autofocus required>
						</div>
						<div class="input-group" style="margin-bottom: 25px"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input class="form-control" placeholder="Пароль" name="password" type="password" value="" required>
						</div>
						<button class="btn btn-lg btn-success btn-block" name="submit" type="submit" value="">Войти</button>
					</fieldset>
					<?php echo form_close();?> </div>
			</div>
		</div>
	</div>
</div>
