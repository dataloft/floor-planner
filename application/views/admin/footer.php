<div id="footer" class="navbar-default" role="navigation">
	<div class="container">
		<div class="navbar-left">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
			</button>
			<!--p class="navbar-brand text-muted"><small>&copy; Airyo 2014</small></p-->
		</div>
		<?if(isset($usermenu)):?>
		<div class="nav collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			<p class="navbar-text navbar-right">
				<span class="glyphicon glyphicon-log-out"></span> 
				<a href="/admin/logout">Выйти</a>
			</p>
		</div>
		<?endif?>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/themes/airyo/js/bootstrap.min.js"></script>

<script type="text/javascript" src="/themes/nsc/area_draw/js/common.js"></script>
<script type="text/javascript" src="/themes/nsc/area_draw/js/scripts.js"></script>
<script type="text/javascript" src="/themes/nsc/js/common.js"></script>


</body>
</html>