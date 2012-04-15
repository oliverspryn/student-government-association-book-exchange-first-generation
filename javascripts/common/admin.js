$(document).ready(function() {
/**
 * Poll
 * ------------------------------------
*/

//Submit a forum comment
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
});