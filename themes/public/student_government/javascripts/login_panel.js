$(document).ready(function() {
//Slide down the login and sign-up panel when the login flag is clicked
	$('section.flag img').click(function() {
		$('section.login').slideToggle();
	});
	
//Slide down the login and sign-up panel when a locked link or button is clicked
	$('.locked').click(function(event) {
	//Don't follow the page!
		event.preventDefault();
		
	//Slide down the panel
		$('section.login').slideDown();
		
	//Slide to the top of the page, where the panel resides
		$('html, body').animate({
			scrollTop: 0
		}, 'slow');
		
	//Set the hidden redirect parameter for the login form
		$('#redirect').val($(this).attr('href'));
	});
});