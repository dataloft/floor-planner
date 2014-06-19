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
<script type="text/javascript" src="/themes/airyo/js/bootstrap.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="/themes/nsc/js/jquery.canvasAreaDraw.min.for.admin.js"></script>
<script type="text/javascript" src="/themes/nsc/js/bootbox.min.js"></script>

<script type="text/javascript" src="/themes/nsc/js/jquery.maphilight.js"></script>
<script type="text/javascript">$(function() {
        $('.map').maphilight();
    });

    var url = document.location.href;
    $.each($(".nav li a"),function(){
        var href = $(this).attr('href');
        var pos = document.location.pathname.indexOf(href);
        if( pos >= 0 && href != '/' || href == document.location.pathname ){
            $(this).parent().addClass('active');
        };
    });

    $(".box-category a").each(function(e){


    });
</script>
</body>
</html>