$(document).ready(function(){
	$('.center_navigation li a').click(function(){
		$('.center_navigation li').removeClass('active');
		$(this).parent().addClass('active');
		
		$('.tabs_content > div').hide();
		$($(this).attr('href')).show();
		
		return false;
	});
	
	$('.korpus a').click(function(){
		$('.korpus a').removeClass('active');
		$(this).addClass('active');
		$('.tabs_korpus > div').hide();
		$($(this).attr('href')).show();
	});
	 $('.map').maphilight();
    
    
    
	$('.popover_style').each(function(){
		var c = $(this).attr("class"); 	
		$(this).popover({'trigger':'hover', template: '<div class="popover '+ c +'"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>' });
		
	});

});
$(window).load(function() {
		$('.gallery_main .jcarousel').jcarousel()
		.jcarouselAutoscroll({
            interval: 3000,
            target: '+=1',
            autostart: true
        });

        $('.gallery_main .jcarousel-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.gallery_main .jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.gallery_main .jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination();
            
        $('.jcarousel-itemphotos .jcarousel').jcarousel({
		    vertical: true
		});
        $('.jcarousel-itemphotos .jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
		$('.jcarousel-itemphotos .jcarousel ul li img').click(function(){
			$('.big_img img').attr('src', $(this).attr('rel'));
			$('.jcarousel-itemphotos .jcarousel ul li').removeClass('active');
			$(this).parent().addClass('active');
		});
});
