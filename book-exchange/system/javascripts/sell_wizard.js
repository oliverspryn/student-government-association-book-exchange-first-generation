$(document).ready(function() {
	var images = new Array();
	var currentImage = 0;
	var container = $('div.imageContainer');
	var backButton = $('span.back');
	var forwardButton = $('span.forward');
	var APIKey = 'AIzaSyCCfXsNv47Xg62-Kz6opyvmn3YBPhliZ0k';
	var APIRequest = 'https://www.googleapis.com/shopping/search/v1/public/products?country=US&key=' + APIKey + '&q=';
	var localRequest = 'api.php?ISBN=';
	
/**
 * Fetch an image from the Google 
 * Shopping API when the book's ISBN
 * is entered
 * ------------------------------------
*/

//Listen for entries in the ISBN and fetch a series of book covers from the Google Shopping API
	$('input.ISBN').change(function() {
		var input = $(this);
		
	//Change the text of the image container
		container.text('Guessing...');
		
	//Check and see if the input is in a valid ISBN format
		var ISBN = input.val().replace(/[^0-9]/g, '');
		
		if (ISBN.length == 10 && input.val().length == ISBN.length) {
		//Check with the local database and see if an entry for this book already exists
			$.ajax({
				'url' : localRequest + ISBN,
				success : function(data) {					
				//Is the book already in the database? If so, let the user know, and give them the option to auto fill the form
					if (data != 'failure') {
						data = $.parseJSON(data);
						
					//Construct the alert dialog with the fetched information from the server
						$('<section class="dialog"><h1>Book Information On Record</h1><div class="content"><div class="imagePreview"><img src="' + data.imageURL + '"></div><div class="bookInfo"><h2>Book Information</h2><span class="titleInfo"><strong>Title:</strong> ' + data.title + '</span><span class="authorInfo"><strong>Author:</strong> ' + data.author + '</span><span class="editionInfo"><strong>Edition:</strong> ' + data.edition + '</div><div class="classInfo"><h2>Class Information</h2><span class="class"><span class="band" style="border-left-color: ' + data.color1 + ';"><span class="icon" style="background-image: url(\'../../data/book-exchange/icons/' + data.course + '/icon_032.png\');">' + data.name + ' ' + data.number + ' ' + data.section + '</span></span></span></div></div><div class="buttons"><button class="green allAccurate">The Book and Class Information are Accurate</button><button class="green">Only the Book Information is Accurate</button><button class="red">No, This Is Incorrect</button>').appendTo('body').delfinidialog();
						
					//Hide the image browser controls
						$('div.imageBrowser').addClass('hidden');
				//If it is not, all we can do is try to fetch a cover image from the Google Shopping API
					} else {
						$.ajax({
							'url' : APIRequest + ISBN,
							'success' : function(data) {
								var APIItems = data.items;
								currentImage = 0;
								
							//Generate the array of possible book URLs
								for (var i = 0; i <= APIItems.length - 1; i++) {
									images.push(APIItems[i].product.images[0].link);
								}
								
							//Put the first image in the placeholder on the page
								container.html('<img src="' + images[0] + '" />');
								
							//Show the image browser controls
								$('div.imageBrowser').removeClass('hidden');
							}
						});
					}
				}
			});
		}
    });
	
//Listen for when the "The Book and Class Information are Accurate" button is clicked in the suggestion dialog
	$('body').delegate('section.dialog div.buttons button.allAccurate', 'click', function() {
		var dialog = $(this).parent().parent();
		var image = dialog.children('div.content').children('div.imagePreview').children('img').attr('src');
		var title = dialog.children('div.content').children('div.bookInfo').children('span.titleInfo').text();
		var author = dialog.children('div.content').children('div.bookInfo').children('span.authorInfo').text();
		var edition = dialog.children('div.content').children('div.bookInfo').children('span.editionInfo').text();
		
	//.substring() will remove the "Title: ", "Author: ", or "Edition: " that was extracted from the dialog
		$('div.imageContainer').html('<img src="' + image + '" />');
		$('input.titleInput').val(title.substring(7, title.length));
		$('input.authorInput').val(author.substring(8, author.length));
		$('input.editionInput').val(edition.substring(9, edition.length));
	});

//Browse through the list of avaliable images
	forwardButton.click(function() {
	//Are we already at the end of the list?
		if (!forwardButton.hasClass('disabled') && images[currentImage + 1] != undefined) {
			currentImage ++;
			container.html('<img src="' + images[currentImage] + '" />');
			
		//Does another image after this one exist, or should the button become disabled?
			if (images[currentImage + 1] == undefined) {
				forwardButton.addClass('disabled');
			}
			
		//Make sure that the back button is enabled
			backButton.removeClass('disabled');
		}
    });
	
	backButton.click(function() {
	//Are we already at the end of the list?
		if (!backButton.hasClass('disabled') && images[currentImage - 1] != undefined) {
			currentImage --;
			container.html('<img src="' + images[currentImage] + '" />');
			
		//Does another image after this one exist, or should the button become disabled?
			if (images[currentImage - 1] == undefined) {
				backButton.addClass('disabled');
			}
			
		//Make sure that the forward button is enabled
			forwardButton.removeClass('disabled');
		}
    });

/**
 * Update the preview sidebar as the
 * form is filled out
 * ------------------------------------
*/

	$('input.titleInput').on('change', function() {
        var input = $(this);
		
		if (input.val() == '') {
			$('span.titlePreview').html('&lt;Book Title&gt;');
		} else {
			$('span.titlePreview').text(input.val());
		}
    });
	
	$('input.authorInput').on('change', function() {
        var input = $(this);
		
		if (input.val() == '') {
			$('span.authorPreview').html('Author: &lt;Book Title&gt;');
		} else {
			$('span.authorPreview').text('Author: ' + input.val());
		}
    });
});