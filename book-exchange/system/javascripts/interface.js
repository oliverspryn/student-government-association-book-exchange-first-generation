$(document).ready(function() {
/**
 * Book exchange category flyout menu
 * ------------------------------------
*/

	var events = $('ul.categoryFly');
	var hovered = false;
	
	events.bind('menuActive', function() {
		hovered = true;
		events.addClass('open');
	});
	
	events.bind('menuInactive', function() {
		hovered = false;
		events.removeClass('open');
	});

	$('ul.categoryFly').click(function() {
		if (!hovered) {
			var menu = $(this);
			
		//Calculate the required height by seeing how many rows are in the first column and multiplying by the height of each one
			var items = menu.children('li:first').children('ul').children('li').length;
			var height = 40 * items;
		
		//Calculate the required width by seeing how many columns exist and multiplying by the width of each one
			var items = menu.children('li').length;
			var width = 250 * items;
			
		//Calculate the offeset height from the top and left so that this can be floated overtop of the other elements and not push elements as it opens
			var top = menu.offset().top;
			var left = menu.offset().left;
			
		//Slide the unselected menu items into view
			menu.css({
				'top' : top + 'px',
				'left' : left + 'px',
				'position' : 'absolute',
				'z-index' : '5'
			}).animate({
				'height' : height + 'px',
				'width' : width + 'px'
			}, function() {
			//Let the application know that the menu is being hovered over
				events.trigger('menuActive');
			}).find('li ul li:not(.selected)').css({
				'display' : 'list-item',
				'height' : '0px',
				'width' : '0px'
			}).animate({
				'height' : '40px',
				'width' : '250px'
			});
		}
	});
	
	$(document).click(function(e) {
		if (!$(e.target).is('ul.categoryFly') && !$(e.target).parents().is('ul.categoryFly')) {
			var menu = $('ul.categoryFly');
			
		//Slide the unselected menu items out of the way
			menu.animate({
				'height' : '40px',
				'width' : '198px'
			}, function() {
			//Remove the styles which were added by the mouseover handler
				menu.removeAttr('style').find('li ul li:not(.selected)').removeAttr('style'); 
				
			//Let the application know that the menu has been hovered out
				events.trigger('menuInactive');
			}).find('li ul li:not(.selected)').animate({
				'height' : '0px',
				'width' : '0px'
			});
		}
	});
	
//Slide the menu out of view on-click
	$('ul.categoryFly li ul li').click(function() {
		if (hovered) {
			var item = $(this);
			var menu = item.parent().parent().parent();
			
		//Remove the selected class from the previously selected item and add the selected class to the clicked one
			menu.find('li ul li.selected').removeClass('selected').css({
				'display' : 'list-item',
				'height' : '40px',
				'width' : '250px'
			});
			
			item.addClass('selected');
			
		//Slide the unselected menu items out of the way
			menu.animate({
				'height' : '40px',
				'width' : '198px'
			}, function() {
			//Remove the styles which were added by the mouseover handler
				menu.removeAttr('style').find('li ul li:not(.selected)').removeAttr('style'); 
				
			//Let the application know that the menu has been hovered out
				events.trigger('menuInactive');
			}).find('li ul li:not(.selected)').animate({
				'height' : '0px',
				'width' : '0px'
			});
		}
	});
	
/**
 * Load a Wikipedia article for each
 * category listing
 * ------------------------------------
*/

	if (parseInt($('article.description').length) > 0) {
		var container = $('article.description');
		
		$.ajax({
			url : 'http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=1&redirects&callback=?',
			dataType: 'json',
			data : {
				titles : container.parent().parent().children('header.styled').children('h1').text() //Fetched from the page <header> element
			},
			success : function(data) {	
			// At some point in the JSON structure, we will need the article ID, which is different for every article, to access the 
			// the body of the article. Since this is an unknown, the we will need to walk through the strcuture and find the ID of
			// the article
				var keys = new Array();
				
				for (var key in data.query.pages) {
					if (data.query.pages.hasOwnProperty(key)){
						keys.push(key);
					}
				}
				
			//If the key is -1, then Wikipedia couldn't find and article on the subject
				if (keys[0] != '-1') {
				//Put the article from Wikipieda in the appropriate container, and remove the loading class
					var article = data.query.pages[keys[0]].extract;
					container.children('section.article').removeClass('loading').html(article);
					
				//Update the "Read More" button to link to the article and show the button
					var link = data.query.pages[keys[0]].title;
					container.children('a.buttonLink').attr('href', 'http://en.wikipedia.org/wiki/' + link).attr('target', '_blank').removeAttr('style');
					
				//Show the disclaimer
					container.children('section.disclaimer').removeClass('hidden');
				} else {
					container.hide();
				}
			}
		});
	}
});