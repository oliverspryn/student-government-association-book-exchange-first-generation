$(document).ready(function() {
/**
 * If the user has not logged, expand
 * the login <section> when the 
 * "Sell Books" button is clicked
 * ------------------------------------
*/

	$('button.openLogin').click(function() {
	//The login panel will exist if the user is not logged
		var panel = $('section.login');
		
		if (panel.length) {
		//Open the login panel
			panel.slideDown();
			
		//Slide it into view
			$('html, body').animate({
				'scrollTop' : '0px'
			}, 'slow');
			
		//Fill the redirect form element
			$('input.redirect').val($(this).attr('data-redirect'))
		} else {
			document.location = 'sell-books/';
		}
	});
	
/**
 * Book exchange category flyout menu
 * ------------------------------------
*/

	var events = $('ul.categoryFly');
	var hovered = false;
	
//Let the application know that the menu is being hovered over
	events.bind('menuActive', function() {
		hovered = true;
	});
	
//Let the application know that the menu is being hovered out
	events.bind('menuInactive', function() {
		hovered = false;
	});

//Expand the menu when it is clicked on
	$('body').delegate('ul.categoryFly', 'click', function() {
		if (!hovered) {
			var documentWidth = $(document).width();
			var documentHeight = $(document).height();
			var menu = $(this);
			menu.addClass('open');
			menu.children('li').css('display', 'table-cell');
			
		//Calculate the required height by seeing how many rows are in the first column and multiplying by the height of each one
			var items = menu.children('li:first').children('ul').children('li').length;
			var height = 40 * items;
		
		//Calculate the required width by seeing how many columns exist and multiplying by the width of each one
			var items = menu.children('li').length;
			var width = 250 * items;
			
		//Calculate the offeset height from the top and left so that this can be floated overtop of the other elements and not push elements as it opens
			var top = menu.offset().top;
			var left = menu.offset().left;
			var newTop = top;
			var newLeft = left;
			
		//Will the menu fly off the bottom of the screen? If so, adjust the position just enough so that the entire menu is visible
			if (top + height > documentHeight) {
				newTop = documentHeight - (documentHeight - top) + (documentHeight - (top + height)) - 20; //-20 is for aesthetics
			}
			
		//Will the menu fly off the side of the screen? If so, just align the whole menu to the vertical center
			if (left + width > documentWidth) {
				newLeft = (documentWidth - width) / 2;
			}
			
		//Slide the unselected menu items into view
			menu.css({
				'left' : left + 'px',
				'position' : 'absolute',
				'top' : top + 'px',
				'z-index' : '5'
			}).animate({
				'left' : newLeft + 'px',
				'height' : height + 'px',
				'top' : newTop + 'px',
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
	
//If something outside of the menu is clicked on, collapse the menu
	$(document).click(function(e) {
		if (!$(e.target).is('ul.categoryFly.open') && !$(e.target).parents().is('ul.categoryFly.open') && $('ul.categoryFly.open').length) {
			var menu = $('ul.categoryFly.open');
			menu.removeClass('open');
			var left = menu.parent().offset().left;
			var top = menu.parent().offset().top;
			
		//Slide the unselected menu items out of the way
			menu.animate({
				'left' : left + 'px',
				'height' : '40px',
				'top' : top + 'px',
				'width' : '198px'
			}, function() {
			//Remove the styles which were added by the mouseover handler
				menu.removeAttr('style').find('li ul li:not(.selected)').removeAttr('style'); 
				
			//In order to fix an issue with Chrome, where the <li> columns only collapse to 1px wide, hide all of the unnecessary columns
				menu.children('li').each(function() {
					var currentColumn = $(this);
					
					if (!currentColumn.has('li.selected').length) {
						currentColumn.css('display', 'none');
					}
				});
				
			//Let the application know that the menu has been hovered out
				events.trigger('menuInactive');
			}).find('li ul li:not(.selected)').animate({
				'height' : '0px',
				'width' : '0px'
			});
		}
	});
	
//Slide the menu out of view on-click
	$('body').delegate('ul.categoryFly li ul li', 'click', function() {
		if (hovered) {
			var item = $(this);
			var menu = item.parent().parent().parent();
			menu.removeClass('open');
			var left = menu.parent().offset().left;
			var top = menu.parent().offset().top;
			
		//Remove the selected class from the previously selected item and add the selected class to the clicked one
			menu.find('li ul li.selected').removeClass('selected').css({
				'display' : 'list-item',
				'height' : '40px',
				'width' : '250px'
			});
			
			item.addClass('selected');
			
		//Grab the value of the selected item and store it in the associated hidden element
			if (item.attr('data-value') == '0') { //This is an invalid value
				menu.parent().find('div div input.collapse').attr('value', '');
			} else {
				menu.parent().find('div div input.collapse').attr('value', item.attr('data-value'));
			}
			
		//Slide the unselected menu items out of the way
			menu.animate({
				'left' : left + 'px',
				'height' : '40px',
				'top' : top + 'px',
				'width' : '198px'
			}, function() {
			//Remove the styles which were added by the mouseover handler
				menu.removeAttr('style').find('li ul li:not(.selected)').removeAttr('style'); 
				
			//In order to fix an issue with Chrome, where the <li> columns only collapse to 1px wide, hide all of the unnecessary columns
				menu.children('li').each(function() {
					var currentColumn = $(this);
					
					if (!currentColumn.has('li.selected').length) {
						currentColumn.css('display', 'none');
					}
				});
				
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
					
				//Is all of the article being displayed, or should a "Read More/Less" button display?
					var normalHieght = container.children('section.article').css('max-height', 'none').height();
					container.children('section.article').removeAttr('style');
					
					if (normalHieght > 350) {
						container.children('a.buttonLink').removeAttr('style');
					}
					
				//Show the disclaimer
					container.children('section.disclaimer').removeClass('hidden');
				} else {
					container.hide();
				}
			}
		});
	}
	
/**
 * Slide the Wikipedia article into 
 * full view
 * ------------------------------------
*/
	
	$('article.description a.buttonLink').click(function() {
		var button = $(this);
		var article = button.siblings('section.article');
		var beforeHeight = article.height();
		var normalHieght = article.css('max-height', 'none').height();
		article.css('height', beforeHeight);
		
		if (button.text() == 'Read More') {
		//Resize the aritcle container
			article.animate({
				'height' : normalHieght + 'px'
			}, 1000, function() {
			//Change the text of the button
				button.html('<span>Read Less</span>');
			});
		} else {
		//Resize the aritcle container
			article.animate({
				'height' : '350px'
			}, 1000, function() {
			//Reset the style tag after animation
				article.removeAttr('style');
				
			//Change the text of the button
				button.html('<span>Read More</span>');
			});			
		}
	});
	
/**
 * Make an offer for a book
 * ------------------------------------
*/
	
	$('a.buttonLink.buy').click(function() {
		$('<section class="purchase" title="Buy"><div class="loading">Please wait...</div></section>').dialog({
			'height' : 600,
			'modal' : true,
			'resizable' : false,
			'width' : 900,
			'create' : function() {
				var dialog = $(this);
				var requestURL = location.substring(0, location.indexOf('book-exchange')) + 'book-exchange/system/server/purchase.php';
			}
		});
	});
	
/**
 * Provide search suggestions when 
 * entering a search query
 * ------------------------------------
*/
	
	var location = document.location.href;
	var requestURL = location.substring(0, location.indexOf('book-exchange')) + 'book-exchange/system/server/suggestions.php';
	
	$('input.search.full').autocomplete({
		'source' : requestURL,
		'minLength' : 2,
		'select' : function(event, ui) {
			$(this).val(ui.item.label).parent().parent().submit();
		}, 'search' : function(event, ui) {
			var search = $(this);
			var searchBy = search.parent().parent().children('div.controls').find('div.dropdownWrapper ul li.selected').text();
			var searchIn = search.parent().parent().children('div.controls').find('div.menuWrapper ul li ul li.selected').attr('data\-value');
			
			if (!searchIn || (searchIn && searchIn == '') || searchIn == undefined) {
				searchIn = search.parent().parent().children('input[type=hidden]').val();
			}
			
			search.autocomplete('option', 'source', requestURL + '?searchBy=' + searchBy + '&category=' + searchIn);
		}
	});	

	$['ui']['autocomplete'].prototype['_renderItem'] = function(ul, item) {
		var details;		

		if (item.total == 1) {
			details = '1 book avaliable for $' + item.price; 
		} else {
			details = item.total + ' books starting at $' + item.price;
		}
		
		return $('<li />').data('item.autocomplete', item).append($('<a title="' + item.label + '"></a>').html('<img src="' + item.image + '" /><span class="title">' + item.label + '</span><span class="author details">Author: ' + item.author + '</span><span class="details total">' + details + '</span>')).appendTo(ul);
	}
	
/**
 * Misc
 * ------------------------------------
*/

//Clear any alert bubbles
	setTimeout(function() {
		$('.success').fadeOut();
	}, 10000);
	
//Expand the advanced search options
	$('span.expand').click(function() {
		$(this).hide().siblings('div.controls').show();
	});
});