/*
 * Yes, this needs to run BEFORE the DOM is ready.
 * 
 * Internet Explorer doesn't render any element it doesn't recognize. (Why???)
 * Fortunately, if these elements are declared via JavaScript, IE will render
 * and style them. CSS will take care of the rest to ensure these "unknown"
 * elements will render properly on older browsers.
 * 
 * Thanks to: http://html5doctor.com/how-to-get-html5-working-in-ie-and-firefox-2/
 */

var HTML5 = new Array('abbr', 'article', 'aside', 'audio', 'bb', 'canvas', 'datagrid', 'datalist', 'details', 'dialog', 'eventsource', 'figure', 'footer', 'header', 'hgroup', 'mark', 'menu', 'meter', 'nav', 'output', 'progress', 'section', 'time', 'video');

$.each(HTML5, function(index, value) {
	$('<' + value + ' />').remove();
});

$(document).ready(function() {
/**
 * Toggle item avalibility input fields
 * ------------------------------------
*/
	
	$('#toggleAvailability').click(function() {
		var check = $(this);
		
	//Is this box checked or unchecked? If it is now checked then enable the required fields, otherwise disable them.
		if (check.is(':checked')) {
			check.parent().parent().children('#from').removeAttr('disabled').next().removeAttr('disabled').next().removeAttr('disabled').next().removeAttr('disabled');
		} else {
			check.parent().parent().children('#from').attr('disabled', 'disabled').next().attr('disabled', 'disabled').next().attr('disabled', 'disabled').next().attr('disabled', 'disabled');
		}
	});
	
/**
 * Calendar setup for date inputs
 * ------------------------------------
*/

	var dates = $('#from, #to').datepicker({
		defaultDate: '+1w',
		showButtonPanel: true,
		changeMonth: false,
		numberOfMonths: 3,
		onSelect: function(selectedDate) {
			var option = this.id == 'from' ? 'minDate' : 'maxDate';
			var instance = $(this).data("datepicker");
			var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker('option', option, date);
		}
	});
	
/**
 * Reset form button
 * ------------------------------------
*/

	$('.reset').click(function(event) {
		var button = $(this);
		
	//Don't follow reset the form until the user has confirmed the action!
		event.preventDefault();
		
	//Force the user to confirm the action	
		$('<div id="itemDeleteTempDialog"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><p>Do you wish to clear the current contents of the form and reset its values?</p></div>').dialog({
			title : 'Confim Reset',
			modal : true,
			resizable : false,
			buttons : {
				'Yes' : function() {
					$(this).dialog('close');
					button.parent().parent()[0].reset();
				},
				'No' : function() {
					$(this).dialog('close');
				}
			}
		});
	});
	
/**
 * Exit form button
 * ------------------------------------
*/

	$('.cancel').click(function() {
		var button = $(this);
		
	//Force the user to confirm the action	
		$('<div id="itemDeleteTempDialog"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><p>Do you wish to leave this page? All unsaved changes will be lost.</p></div>').dialog({
			title : 'Confim Cancel',
			modal : true,
			resizable : false,
			buttons : {
				'Yes' : function() {
					document.location.href = button.attr('data-url');
				},
				'No' : function() {
					$(this).dialog('close');
				}
			}
		});
	});
	
/**
 * Item visibility
 * ------------------------------------
*/

	$('span.visibleToggle').click(function() {
		var visibility = $(this);
		
	//Is this hidden or visible?
		if (visibility.hasClass('display')) {
		//Make the icon a closed eye
			visibility.removeClass('display').addClass('noDisplay');
			
		//Update the hover tip
			visibility.attr('title', 'This item is currently hidden');
			$('.tip').tipTip();
			
		//Send the request the to server
			$.ajax({
				url : document.location.href,
				type : 'POST',
				data : {
					id : visibility.attr('id'),
					action : 'setAvaliability'
				}
			});
		} else {
		//Make the icon an open eye
			visibility.removeClass('noDisplay').addClass('display');
			
		//Update the hover tip
			visibility.attr('title', 'This item is currently being displayed');
			$('.tip').tipTip();
			
		//Send the request the to server
			$.ajax({
				url : document.location.href,
				type : 'POST',
				data : {
					id : visibility.attr('id'),
					action : 'setAvaliability',
					option : 'on'
				}
			});
		}
	});
	
/**
 * Item positioning
 * ------------------------------------
*/

	$('select.position').change(function() {
		var position = $(this);
	
	//Get the URL without the query string
		var baseURL = [location.protocol, '//', location.host, location.pathname].join('');
		
	//Go to the URL for processing
		document.location.href = baseURL + '?action=modifySettings&id=' + position.attr('id') + '&currentPosition=' + position.parent().children('.currentPosition').val() + '&position=' + position.val();
	});
	
/**
 * Delete an item
 * ------------------------------------
*/

	$('a.delete').click(function(event) {
		var deleteLink = $(this);
		
	//Don't follow the link until the user has confirmed the action!
		event.preventDefault();
		
	//Force the user to confirm the action
		if (deleteLink.hasClass('fileShare')) {
			var text = 'You are about to delete this item and all files associated with this file share item. This action cannot be undone. Continue?';
		} else {
			var text = 'You are about to delete this item. This action cannot be undone. Continue?';
		}
	
		$('<div id="itemDeleteTempDialog"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><p>' + text + '</p></div>').dialog({
			title : 'Confim Deletion',
			modal : true,
			resizable : false,
			buttons : {
				'Yes' : function() {
					document.location.href = deleteLink.attr('href');
				},
				'No' : function() {
					$(this).dialog('close');
				}
			}
		});
	});

/**
 * Poll
 * ------------------------------------
*/

//Submit a poll response
	$('.pollSubmit').click(function() {
		var poll = $(this);
		var checked = poll.parent().children('label:has(:radio:checked)').children('input').val();
		
		if (checked != undefined) {
		//Change the button label to show that processing is going on...
			poll.text('Please wait...');
			
		//Construct the data object here, since it will contain one dynamic variable
			var data = new Object();
			data.poll = poll.parent().parent().children('.id').val();
			data['poll_' + poll.parent().parent().children('.id').val()] = checked;
			
			$.ajax({
				url : 'index.php',
				type : 'POST',
				data : data,
				success : function(data) {
				//Animate the progress bar
					var resultsRow = poll.parent().parent().find('table tbody tr').eq(checked).children('td');
					var size = parseInt(resultsRow.children('span.size').text()) + 1;
					var total = parseInt(resultsRow.children('span.total').text());
					var percent = (size / total) * 100;
				
					resultsRow.find('div div').animate({
						'width' : percent + '%'
					}, 750);
					
				//Add one to the total number that voted for this option
					resultsRow.children('span.size').text(size);
					
				//Hide the voting options
					poll.parent().animate({
						'opacity' : '0'
					}, 750, function() {
						$(this).slideUp(1000, function() {
							$(this).remove();
						});
					});
				}
			});
		}
	});

/**
 * Forum
 * ------------------------------------
*/	

//Submit a forum comment
	$('.forumSubmit').click(function() {
		var forum = $(this);
		var forumID = forum.parent().children('input:hidden[name=itemID]').val();
		
		if (forum.parent().children('textarea').val() == "") {
			
		} else {
		//Change the button label to show that processing is going on...
			forum.text('Please wait...');
			
		//Construct the data object here, since it will contain one dynamic variable
			var data = new Object();
			data.itemID = forumID;
			data.id = forum.parent().children('input:hidden[name=id]').val();
			data['comment_' + forumID] = forum.parent().children('textarea').val()
			
		//Send the request to the server
			$.ajax({
				url : 'index.php',
				type : 'POST',
				data : data,
				success : function(data) {
				//Parse the retuned data and build HTML to inject into the page
					var returnedData = $.parseJSON(data);
					var HTML = '<div><span class=\"tip smallDelete commentDelete\" title=\"Delete comment\"></span>&nbsp;<a class="user" href="users/profile.php?id=' + returnedData.id + '">' + returnedData.name + '</a> ' + returnedData.comment + '<br><br><span class="date">' + returnedData.date + '</span></div>';
					
				//Empty the textarea
					forum.parent().children('textarea').val('');
					
				//Reset the button text
					forum.text('Comment');
					
				//Make sure the delete all comments button is showing
					forum.parent().children('.forumDelete').show();
					
				//Inject the HTML into the page and highlight the background to indicate that it is a new item
					$(HTML).appendTo(forum.parent().children('div.commentWrapper')).css('background-color', '#FF9').animate({
						'background-color' : '#FFF'
					}, 2000);
					
				//Run TipTip on this new comment
					$('.tip').tipTip();
				}
			});
		}
	});
	
//Delete single forum comment
	$('.commentDelete').live('click', function() {
		var button = $(this);
		var wrapper = button.parent().parent();
		
		$('<div id="forumDeleteTempDialog"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are about to delete a comment in this forum. This action cannot be undone. Continue?</p></div>').dialog({
			title : 'Comfirm Comment Deletion',
			modal : true,
			resizable : false,
			buttons : {
				'Yes' : function() {
				//Close the dialog
					$(this).dialog('close');
					
				//Fade out the comment, remove the content from the wrapper, and hide the delete all button if no comments remain
					button.parent().animate({
						opacity : '0'
					}, 750, function() {
						$(this).slideUp(1000, function() {
							$(this).remove();
							
							if (wrapper.text().replace(/\n/g,'') == "") {
								wrapper.parent().children('.forumDelete').hide();
							}
						});
					});
					
				//Find out which comment number the deleted comment is, 1 is at top...
					var commentNumber = 1;
					
					$(wrapper.children('div')).each(function() {
						if ($(this).children('span.date').text() == button.parent().children('span.date').text()) {
							return false;
						}
						
						commentNumber ++;
					});
					
				//Send the request to the server
					$.ajax({
						url : 'index.php',
						type : 'GET',
						data : {
							id : button.parent().parent().parent().children('input:hidden[name=itemID]').val(),
							action : 'delete',
							comment : commentNumber
						}
					})
				},
				'No' : function() {
					$(this).dialog('close');
				}
			}
		});
	});
	
//Delete all forum items
	$('.forumDelete').click(function() {
		var button = $(this);
		
		$('<div id="forumDeleteTempDialog"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are about to delete all of the comments in this forum! This action cannot be undone. Continue?</p></div>').dialog({
			title : 'Comfirm Comment Deletion',
			modal : true,
			resizable : false,
			buttons : {
				'Yes' : function() {
				//Close the dialog
					$(this).dialog('close');
					
				//Fade out the comments, remove the content from the wrapper, and hide the delete button
					button.parent().children('div.commentWrapper').animate({
						opacity : '0'
					}, 750, function() {
						$(this).slideUp(1000, function() {
							$(this).text('').removeAttr('style');
							button.hide();
						});
					});
					
				//Send the request to the server
					$.ajax({
						url : 'index.php',
						type : 'GET',
						data : {
							id : button.parent().children('input:hidden[name=itemID]').val(),
							action : 'delete',
							comment : 'all'
						}
					})
				},
				'No' : function() {
					$(this).dialog('close');
				}
			}
		});
	});
	
/**
 * Agenda
 * ------------------------------------
*/

//Open the comments windows
	$('.openComment').click(function() {
		var comment = $(this);
		
	//Get the content to place in the dialog
		var titleText = comment.parent().parent().children('td.taskName').text();
		var text = comment.parent().children('div').html();
		
	//Create a dialog with the comment as its content
		$('<div>' + text + '</div>').dialog({
			title : titleText,
			width : '640',
			height : '480',
			resizable : false,
			buttons : {
				'Close' : function() {
					$(this).dialog('close').remove();
				}
			}
		});
	});
	
//Check and uncheck a list item then update the overall progress bar
	$('.updateTask').click(function() {
		var task = $(this);
		
	//Grab the total and completed number of tasks
		var total = task.parent().parent().parent().parent().parent().parent().children('.totalItems');
		var completed = task.parent().parent().parent().parent().parent().parent().children('.totalComplete');
		
	//Change the checkbox icon, tooltip, and calculate the total completed tasks
		if (task.hasClass('checked')) {
			task.removeClass('checked').addClass('unchecked').attr('title', 'Click to mark as completed');
			$('.tip').tipTip();
			
			completed.val(parseInt(completed.val()) - 1);
		} else {
			task.removeClass('unchecked').addClass('checked').attr('title', 'Click to mark as incomplete');
			$('.tip').tipTip();
			
			completed.val(parseInt(completed.val()) + 1);
		}
		
		var percent = Math.round((parseInt(completed.val()) / parseInt(total.val())) * 100);
		
	//Animate the progress bar
		task.parent().parent().parent().parent().parent().parent().children('div.ui-progressbar').children('div').animate({
			'width' : percent + '%'
		}, 750);
		
	//Send the request to the server
		var data = new Object();
		data.action = "setCompletion";
		data.id = task.attr('id');
		data.oldValue = task.attr('data-value');
		
		if (task.hasClass('unchecked')) {
			data.option = "2";
		}
	
		$.ajax({
			url : document.location.href,
			type : 'POST',
			data : data
		});
	});

 /*
 * TipTip
 * Copyright 2010 Drew Wilson
 * www.drewwilson.com
 * code.drewwilson.com/entry/tiptip-jquery-plugin
 *
 * Version 1.3   -   Updated: Mar. 23, 2010
 *
 * This Plug-In will create a custom tooltip to replace the default
 * browser tooltip. It is extremely lightweight and very smart in
 * that it detects the edges of the browser window and will make sure
 * the tooltip stays within the current window size. As a result the
 * tooltip will adjust itself to be displayed above, below, to the left 
 * or to the right depending on what is necessary to stay within the
 * browser window. It is completely customizable as well via CSS.
 *
 * This TipTip jQuery plug-in is dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

	$.fn.tipTip = function(options) {
		var defaults = { 
			activation: "hover",
			keepAlive: false,
			maxWidth: "200px",
			edgeOffset: 3,
			defaultPosition: "bottom",
			delay: 400,
			fadeIn: 200,
			fadeOut: 200,
			attribute: "title",
			content: false, // HTML or String to fill TipTIp with
		  	enter: function(){},
		  	exit: function(){}
	  	};
	 	var opts = $.extend(defaults, options);
	 	
	 	// Setup tip tip elements and render them to the DOM
	 	if($("#tiptip_holder").length <= 0){
	 		var tiptip_holder = $('<div id="tiptip_holder" style="max-width:'+ opts.maxWidth +';"></div>');
			var tiptip_content = $('<div id="tiptip_content"></div>');
			var tiptip_arrow = $('<div id="tiptip_arrow"></div>');
			$("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')));
		} else {
			var tiptip_holder = $("#tiptip_holder");
			var tiptip_content = $("#tiptip_content");
			var tiptip_arrow = $("#tiptip_arrow");
		}
		
		return this.each(function(){
			var org_elem = $(this);
			if(opts.content){
				var org_title = opts.content;
			} else {
				var org_title = org_elem.attr(opts.attribute);
			}
			if(org_title != ""){
				if(!opts.content){
					org_elem.removeAttr(opts.attribute); //remove original Attribute
				}
				var timeout = false;
				
				if(opts.activation == "hover"){
					org_elem.hover(function(){
						active_tiptip();
					}, function(){
						if(!opts.keepAlive){
							deactive_tiptip();
						}
					});
					if(opts.keepAlive){
						tiptip_holder.hover(function(){}, function(){
							deactive_tiptip();
						});
					}
				} else if(opts.activation == "focus"){
					org_elem.focus(function(){
						active_tiptip();
					}).blur(function(){
						deactive_tiptip();
					});
				} else if(opts.activation == "click"){
					org_elem.click(function(){
						active_tiptip();
						return false;
					}).hover(function(){},function(){
						if(!opts.keepAlive){
							deactive_tiptip();
						}
					});
					if(opts.keepAlive){
						tiptip_holder.hover(function(){}, function(){
							deactive_tiptip();
						});
					}
				}
			
				function active_tiptip(){
					opts.enter.call(this);
					tiptip_content.html(org_title);
					tiptip_holder.hide().removeAttr("class").css("margin","0");
					tiptip_arrow.removeAttr("style");
					
					var top = parseInt(org_elem.offset()['top']);
					var left = parseInt(org_elem.offset()['left']);
					var org_width = parseInt(org_elem.outerWidth());
					var org_height = parseInt(org_elem.outerHeight());
					var tip_w = tiptip_holder.outerWidth();
					var tip_h = tiptip_holder.outerHeight();
					var w_compare = Math.round((org_width - tip_w) / 2);
					var h_compare = Math.round((org_height - tip_h) / 2);
					var marg_left = Math.round(left + w_compare);
					var marg_top = Math.round(top + org_height + opts.edgeOffset);
					var t_class = "";
					var arrow_top = "";
					var arrow_left = Math.round(tip_w - 12) / 2;

                    if(opts.defaultPosition == "bottom"){
                    	t_class = "_bottom";
                   	} else if(opts.defaultPosition == "top"){ 
                   		t_class = "_top";
                   	} else if(opts.defaultPosition == "left"){
                   		t_class = "_left";
                   	} else if(opts.defaultPosition == "right"){
                   		t_class = "_right";
                   	}
					
					var right_compare = (w_compare + left) < parseInt($(window).scrollLeft());
					var left_compare = (tip_w + left) > parseInt($(window).width());
					
					if((right_compare && w_compare < 0) || (t_class == "_right" && !left_compare) || (t_class == "_left" && left < (tip_w + opts.edgeOffset + 5))){
						t_class = "_right";
						arrow_top = Math.round(tip_h - 13) / 2;
						arrow_left = -12;
						marg_left = Math.round(left + org_width + opts.edgeOffset);
						marg_top = Math.round(top + h_compare);
					} else if((left_compare && w_compare < 0) || (t_class == "_left" && !right_compare)){
						t_class = "_left";
						arrow_top = Math.round(tip_h - 13) / 2;
						arrow_left =  Math.round(tip_w);
						marg_left = Math.round(left - (tip_w + opts.edgeOffset + 5));
						marg_top = Math.round(top + h_compare);
					}

					var top_compare = (top + org_height + opts.edgeOffset + tip_h + 8) > parseInt($(window).height() + $(window).scrollTop());
					var bottom_compare = ((top + org_height) - (opts.edgeOffset + tip_h + 8)) < 0;
					
					if(top_compare || (t_class == "_bottom" && top_compare) || (t_class == "_top" && !bottom_compare)){
						if(t_class == "_top" || t_class == "_bottom"){
							t_class = "_top";
						} else {
							t_class = t_class+"_top";
						}
						arrow_top = tip_h;
						marg_top = Math.round(top - (tip_h + 5 + opts.edgeOffset));
					} else if(bottom_compare | (t_class == "_top" && bottom_compare) || (t_class == "_bottom" && !top_compare)){
						if(t_class == "_top" || t_class == "_bottom"){
							t_class = "_bottom";
						} else {
							t_class = t_class+"_bottom";
						}
						arrow_top = -12;						
						marg_top = Math.round(top + org_height + opts.edgeOffset);
					}
				
					if(t_class == "_right_top" || t_class == "_left_top"){
						marg_top = marg_top + 5;
					} else if(t_class == "_right_bottom" || t_class == "_left_bottom"){		
						marg_top = marg_top - 5;
					}
					if(t_class == "_left_top" || t_class == "_left_bottom"){	
						marg_left = marg_left + 5;
					}
					tiptip_arrow.css({"margin-left": arrow_left+"px", "margin-top": arrow_top+"px"});
					tiptip_holder.css({"margin-left": marg_left+"px", "margin-top": marg_top+"px"}).attr("class","tip"+t_class);
					
					if (timeout){ clearTimeout(timeout); }
					timeout = setTimeout(function(){ tiptip_holder.stop(true,true).fadeIn(opts.fadeIn); }, opts.delay);	
				}
				
				function deactive_tiptip(){
					opts.exit.call(this);
					if (timeout){ clearTimeout(timeout); }
					tiptip_holder.fadeOut(opts.fadeOut);
				}
			}				
		});
	}
	
/**
 * Initialize TipTip
 * ------------------------------------
*/

	$('.tip').tipTip();
});

/**
 * Adding table rows
 * ------------------------------------
*/
	
function addAgenda(tableID, cellOneStart, cellOneEnd, cellTwoStart, cellTwoEnd, cellThreeStart, cellThreeEnd, cellFourStart, cellFourEnd, cellFiveStart, cellFiveEnd) {
	var oRows = document.getElementById(tableID).getElementsByTagName('tr');
	var tbl = document.getElementById(tableID);
	var newRow = tbl.insertRow(tbl.rows.length);
	var previousID = document.getElementById(tableID).getElementsByTagName("tr")[tbl.rows.length - 2].id;
	var currentID = Number(previousID) + 1;
	newRow.id = currentID;
	newRow.align = "center";
	
	var newCell1 = newRow.insertCell(0);
	newCell1.innerHTML = cellOneStart + currentID + cellOneEnd;
	
	var newCell2 = newRow.insertCell(1);
	newCell2.innerHTML = cellTwoStart + currentID + cellTwoEnd;
	
	var newCell3 = newRow.insertCell(2);
	newCell3.innerHTML = cellThreeStart + currentID + cellThreeEnd;
	
	var newCell4 = newRow.insertCell(3);
	newCell4.innerHTML = cellFourStart + currentID + cellFourEnd;
	
	var newCell5 = newRow.insertCell(4);
	newCell5.innerHTML = cellFiveStart + currentID + cellFiveEnd;
	
	var newCell6 = newRow.insertCell(5);
	newCell6.innerHTML = "<span class=\"tip smallDelete\" title=\"Delete task\" onclick=\"deleteObject('agenda', '" + currentID + "')\">";
	
	$('.tip').tipTip();
}

function addCategory(tableID, startHTML, middle1HTML, middle2HTML, endHTML, type) {
	var oRows = document.getElementById(tableID).getElementsByTagName('tr');
	var tbl = document.getElementById(tableID);
	var newRow = tbl.insertRow(tbl.rows.length);
	var previousID = document.getElementById(tableID).getElementsByTagName("tr")[tbl.rows.length - 2].id;
	var currentID = Number(previousID) + 1;
	newRow.id = currentID;
	newRow.align = "center";
	
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 25;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	var directory = randomstring.toLowerCase();
	
	var newCell1 = newRow.insertCell(0);
	newCell1.innerHTML = startHTML + currentID + middle1HTML + directory + middle2HTML + currentID + endHTML;
	
	var newCell2 = newRow.insertCell(1);
	newCell2.innerHTML = "<span class=\"action smallDelete\" onclick=\"deleteObject('files', '" + currentID + "')\">";
	$('.tip').tipTip();
}

function addQuestion(tableID, startHTML, middle1HTML, middle2HTML, endHTML) {
	var oRows = document.getElementById(tableID).getElementsByTagName('tr');
	var tbl = document.getElementById(tableID);
	var newRow = tbl.insertRow(tbl.rows.length);
	var previousID = document.getElementById(tableID).getElementsByTagName("tr")[tbl.rows.length - 2].id;
	var currentID = Number(previousID) + 1;
	newRow.id = currentID;
	newRow.align = "center";
	
	var newCell1 = newRow.insertCell(0);
	newCell1.innerHTML = startHTML + currentID + middle1HTML + currentID +  middle2HTML + currentID + endHTML;
	
	var newCell2 = newRow.insertCell(1);
	newCell2.innerHTML = "<span class=\"action smallDelete\" onclick=\"deleteObject('questions', '" + currentID + "')\">";
	$('.tip').tipTip();
}

function deleteObject(tableID, rowID, input) {
	var tbl = document.getElementById(tableID);
	var row = document.getElementById(rowID);
	
	if (tableID != "questions") {
		var minRows = 2;
	} else {
		var minRows = 3;
	}
	
	if (tbl.rows.length > minRows) {
		if (tableID != "files") {
			row.parentNode.removeChild(row);
			
			if (input == parseFloat(input) || input == "0") {
				var field = document.getElementById('removeData');
				var values = field.value;
				
				if (values == "") {
					field.value = input;
				} else {
					field.value = field.value + "," + input;
				}
			}
		} else {
			var removeConfirm = confirm("Warning: Removing this category will remove all files within this category. Continue?");
			
			if (removeConfirm) {
				row.parentNode.removeChild(row);
			}
		}
	} else {
		var text = minRows - 1;
		
		alert("You must have at least " + text + " item(s) in this list");
	}
}