(function ($) {
	/* Detect window width */
	$(window).ready(function() {
		$("body").append('<span id="windowsize" class="dev">TEST</span>');
		
		//console.log('Window size detection startet.');
		var wi = $(window).width();
		$("span#windowsize").text('Width: ' + wi + 'px');
		//console.log('Window size written.');

		$(window).resize(function() {
			var wi = $(window).width();
			$("span#windowsize").text('Width: ' + wi + 'px');

		});
	});
})(jQuery);