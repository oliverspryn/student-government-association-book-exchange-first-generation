<?php
//Header functions
	require_once("../../../../Connections/connDBA.php");

//Define this as a javascript file
	header ("Content-type: text/javascript");
?>
(function($) {
	$(document).ready(function() {
	//Slide down the login and sign-up panel when the login flag is clicked
		$('section.flag img').click(function() {
			$('section.login').slideToggle();
		});
		
	//Slide down the login and sign-up panel when a locked link or button is clicked
		$('.locked').click(function(event) {
			var clicked = $(this);
		
		//Don't follow the page!
			event.preventDefault();
			
		//Slide down the panel
			$('section.login').slideDown();
			
		//Slide to the top of the page, where the panel resides
			$('html, body').animate({
				scrollTop: 0
			}, 'slow');
			
		//Set the hidden redirect parameter for the login form
			if (clicked.attr('href') !== undefined) {
				$('.redirect').val(clicked.attr('href'));
			} else if (clicked.attr('data-redirect') !== undefined) {
				$('.redirect').val(clicked.attr('data-redirect'));
			}
		});
		
	//Monitor when to display the placeholder text in the book exchange search input field
		$('section.search input.search').keyup(function() {
			var input = $(this);
			
			if (input.val() != '') {
				input.addClass('noBackground');
			} else {
				input.removeClass('noBackground');
			}
		});
		
	//Submit the search form when the arrow is clicked
		$('section.search span.performSearch').click(function() {
			$(this).parent().submit();
		});
		
	//Provide search suggestions
		$('input.search.template').autocomplete({
			'source' : '<?php echo $root; ?>book-exchange/system/server/suggestions.php?searchBy=title&category=0',
			'minLength' : 2,
			'select' : function(event, ui) {
				$(this).val(ui.item.label).parent().submit();
			}
		});
		
		$['ui']['autocomplete'].prototype['_renderItem'] = function(ul, item) {
			var details;
			
			if (item.total == 1) {
				details = '1 book avaliable for \$' + item.price; 
			} else {
				details = item.total + ' books starting at \$' + item.price;
			}
			
			return $('<li />').data('item.autocomplete', item).append($('<a title=\"' + item.label + '\"></a>').html('<img src=\"' + item.image + '\" /><span class=\"title\">' + item.label + '</span><span class=\"author details\">' + item.byLine + '</span><span class=\"details total\">' + details + '</span>')).appendTo(ul);
		};
	});
})(jQuery);