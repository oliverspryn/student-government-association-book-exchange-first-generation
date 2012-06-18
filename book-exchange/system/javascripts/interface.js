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
			menu.parent().find('input').attr('value', item.attr('data-value'));
			
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
		var title = $(this).siblings('span.title, a.title').text();
		var id = $(this).attr('data-fetch');
		
		var parentDialog = $('<section class="purchase" title="Purchase <i>' + title + '</i>"><div class="loading">Please wait...</div></section>').dialog({
			'height' : 600,
			'modal' : true,
			'resizable' : false,
			'width' : 900,
			'buttons' : {
				'Send Request' : function() {
					var confirmDialog = $('<section class="confirm" title="Confirm Request"></section>')
					.html('<p><span class="ui-icon ui-icon-alert"></span>Are you sure you wish to send a request to purchase this book at the listed price from the seller? Your name and email address will be shared with this person.</p><p>Clicking &quot;Yes&quot; will immediately initiate the transaction.</p>')
					.dialog({
						'height' : 300,
						'modal' : true,
						'resizable' : false,
						'width' : 500,
						'buttons' : {
							'Yes' : function() {
								var requestURL = location.substring(0, location.indexOf('book-exchange')) + 'book-exchange/system/server/purchase-request.php?id=' + id;
								
							//Close the open dialogs
								confirmDialog.dialog('close').remove();
								parentDialog.dialog('close').remove();
								
							//Display a sending request notice
								var message = $('<div class="center"><div class="message">Sending purchase request...</div></div>').appendTo('body');
								
								$.ajax({
									'url' : requestURL,
									'success' : function(data) {
										if (data == 'success') {
										//Update the message to the user
											message.html('<div class="success">Purchase request sent! The seller will respond via email.</div>');
											
										//Remove the message after a certain period of time
											setTimeout(function() {
												message.fadeOut(400, function() {
													$(this).remove();
												});
											}, 10000);
										} else {
										//Update the message to the user
											message.html('<div class="error">Purchase request could not be sent. Please refresh the page and try again.</div>');
										}
									}
								});
							}, 'No' : function() {
								$(this).dialog('close').remove();
							}
						}
					});
				}, 'Help' : function() {
					var helpDialog = $('<section class="helpDialog" title="How Does This Work?"></section>')
					.html('<p>Once you click the &quot;Send Request&quot; button, the seller will be sent an email notifying him or her that you would like to purchase this book. This person will be prompted to send you a reply email with a place and time to meet in person so that you may recieve this book.</p>')
					.dialog({
						'height' : 300,
						'modal' : true,
						'resizable' : false,
						'width' : 500,
						'buttons' : {
							'Close' : function() {
								$(this).dialog('close').remove();
							} 
						}
					});
				}, 'Cancel' : function() {
					$(this).dialog('close').remove();
				}
			},
			'create' : function() {
				var dialog = $(this);
				var location = document.location.href;
				var requestURL = location.substring(0, location.indexOf('book-exchange')) + 'book-exchange/system/server/purchase-data.php?id=' + id;
				
				$.ajax({
					'dataType' : 'json',
					'url' : requestURL,
					'success' : function(data) {
						var HTML = '<aside class="bookInfo">';
						HTML += '<div class="cover"><img src="' + data.imageURL + '" /></div>';
						HTML += '<span class="previewTitle">' + data.title + '</span>';
						HTML += '<span class="buttonLink"><span>$' + data.price + '</span></span>';
						HTML += '<span class="previewDetails"><strong>ISBN:</strong> ' + data.ISBN + '</span>';
						HTML += '<span class="previewDetails"><strong>Author:</strong> ' + data.author + '</span>';
						
						if (data.edition != '') {
							HTML += '<span class="previewDetails"><strong>Edition:</strong> ' + data.edition + '</span>';
						}
						
					//Conditionally format the condition statement
						if (data.condition == "Excellent") {
							HTML += '<span class="previewDetails"><strong>Condition:</strong> <span style="color: #33CC66;">Excellent</span></span>';
						} else if (data.condition == "Very Good") {
							HTML += '<span class="previewDetails"><strong>Condition:</strong> <span style="color: #0099FF;">Very Good</span></span>';
						} else if (data.condition == "Good") {
							HTML += '<span class="previewDetails"><strong>Condition:</strong> <span style="color: #FFCC33;">Good</span></span>';
						} else if (data.condition == "Fair") {
							HTML += '<span class="previewDetails"><strong>Condition:</strong> <span style="color: #FF6633;">Fair</span></span>';
						} else if (data.condition == "Poor") {
							HTML += '<span class="previewDetails"><strong>Condition:</strong> <span style="color: #CC0000;">Poor</span></span>';
						}
						
					//Conditionally format the written in statement
						if (data.written == 'No') {
							HTML += '<span class="previewDetails"><strong>Written in:</strong> <span style="color: #33CC66;">No</span></span>';
						} else {
							HTML += '<span class="previewDetails"><strong>Written in:</strong> <span style="color: #CC0000;">Yes</span></span>';
						}
						
						HTML += '</aside><section class="main">';
						HTML += '<div class="userInfo"><h2>Seller information:</h2><div><span>' + data.firstName + ' ' + data.lastName + '</span><span>Email: <a class="highlight" href="mailto:' + data.email + '">' + data.email + '</a></span></div></div>';
						
						if (data.comments != '') {
							HTML += '<h2>User comments:</h2><div class="comments">' + data.comments + '</div>';
						}
						
						HTML += '<h2>Classes used:</h2><div class="classes"><ul>';
						
					//Split the class data into an array and display each class individually
						var location = document.location.href;
						var classes = data.class.split(',');
						var classIDs = data.classID.split(',');
						var colors = data.color.split(',');
						var icon;
						
						for(var i = 0; i <= classes.length - 1; i++) {
							icon = location.substring(0, location.indexOf('book-exchange')) + 'data/book-exchange/icons/' + classIDs[i] + '/icon_032.png';
							
							HTML += '<li><span class="class"><span class="band" style="border-left-color: ' + colors[i] + ';"><span class="icon" style="background-image: url(' + icon + ')">' + classes[i] + '</span></span></span></li>'
						}
						
						HTML += '</ul></div></section>';
						
						dialog.html(HTML);
					}
				});
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
	
//Animate the magnifying glass on the search page
	var magnifier = $('img.animatedSearch');
	
	if (magnifier && magnifier != undefined) {
		var containerWidth = $(document).width();
		var magnifierWidth = 219;
		
	//We need everything in terms of percents, so calculute the total percentage that the glass takes up
		var magnifierPercent = Math.round((magnifierWidth / containerWidth) * 100);
		
		magnifier.animate({
			'left' : (100 - magnifierPercent - 12) + '%'
		}, 150000);
	}

//Clear any alert bubbles
	setTimeout(function() {
		$('.success').fadeOut();
	}, 10000);
	
//Expand the advanced search options
	$('span.expand').click(function() {
		$(this).hide().siblings('div.controls').show();
	});
});