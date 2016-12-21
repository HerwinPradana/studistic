$(document).ready(function(){
	$('.scroll-up').click(function(){
		$('html, body').stop(true, false).animate({scrollTop: 0}, 800);
	});
});
