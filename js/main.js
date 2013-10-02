/*console:true */

(function ($) {
	$(document).ready(function(){
		
		/* Logo link */
		$("#logo").click(function(){
		//$("#logo").css('cursor','pointer').click(function(){
			window.location=$(this).find("a").attr("href");
			return false;
		});
		
		/* For external links in menu */
		$('#nav_full a').each(function() {
			var a = new RegExp('/' + window.location.host + '/');
			if(!a.test(this.href)) {
				$(this).parent().addClass("outbound");
				$(this).click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					window.open(this.href, '_blank');
				});
			}
		});
	
		/* Menu */
		
		$("#nav_full > ul > li.expanded > a").each(function() {
			//$(this).attr("data-oldhref", $(this).attr("href"));
			//$(this).removeAttr("href");
			//$(this).attr('disabled', 'disabled');
		});
		
		$("#nav_full > ul > li.expanded > a").click(function(event) {
			//return false;
			//w3c:
			event.preventDefault();
			event.stopPropagation();
			//IE:
			event.returnValue = false;
			event.cancelBubble = true;
			
			//console.log('Clicked');
			
			$("#nav_full ul ul").slideUp();
			$(".subnavopen").removeClass("subnavopen");
			//console.log($(this).next());
			
			if(!$(this).next().is(":visible")) {
				$(this).next().slideDown();
				$(this).addClass("subnavopen");
			}

		});
		
		/*
		// Initialise audio.js
		audiojs.events.ready(function() {
			var as = audiojs.createAll();
		});
		*/
		
	});
	
	$(window).load(function() {
		$('.rs-carousel ul li').shuffle();
		$(".rs-carousel ul").css({"padding-left": 0});
		
		$('.rs-carousel').carousel({
			orientation: 'horizontal',
			itemsPerTransition: 'auto',
			loop: false,
			speed: 'normal',
			easing: 'swing',
			pagination: true,
			nextPrevActions: true,
			whitespace: false,
			autoScroll: true,
			pause: 4000,
			continuous: false,
			//translate3d: Modernizr && Modernizr.csstransforms3d,
			//touch: Modernizr && Modernizr.touch
		});
	});
	
})(jQuery);