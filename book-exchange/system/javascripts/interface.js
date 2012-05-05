$(document).ready(function() {
/**
 * Book exchange category flyout menu
 * ------------------------------------
*/

	var close = false;

	$('.categoryFly').hover(function() {
		var menu = $(this);
		
	//Calculate the required height by seeing how many list items exist within this tag and multiplying by the height
		var height = 40;
		var counter = 0;
		
		menu.children('li').each(function() {
			counter ++;
		});
		
	//Slide the unselected menu items into view
		menu.find('li:not(.selected)').slideDown();
		
	//Calculate the offeset height from the top and left so that this can be floated overtop of the other elements and not push elements as it opens
		var top = menu.offset().top;
		var left = menu.offset().left;
		
		menu.css({
			'top' : top + 'px',
			'left' : left + 'px',
			'position' : 'absolute',
			'z-index' : '5'
		}).animate({
			'height' : (counter * height) + 'px',
			'width' : '200px'
		}, function() {
			close = false;
		});
	}, function() {
		var menu = $(this);
		
		setTimeout(function() {
			if (!close) {
			//Slide the unselected menu items out of the way
				menu.find('li:not(.selected)').slideUp();
				
			//Slide up the menu
				menu.animate({
					'height' : '40px',
					'width' : '50px'
				}, function() {					
				//Remove the styles which were added by the mouseover function
					menu.removeAttr('style');
					
					close = true;
				});
			}
		}, 250);
	});
	
//Slide the menu out of view on-click
	$('ul.categoryFly li').click(function() {
		var item = $(this);
		var menu = item.parent();
		
	//Remove the selected class from the previously selected item, we'll add it later
		menu.children('li').each(function() {
			$(this).removeAttr('class');
		});
		
		item.addClass('selected');
		
	//Slide the unselected menu items out of the way
		menu.find('li:not(.selected)').slideUp();
		
	//Slide up the menu
		menu.animate({
			'height' : '40px',
			'width' : '50px'
		}, function() {					
		//Remove the styles which were added by the mouseover function
			menu.removeAttr('style');
			
			close = true;
		});
	});
});