$(document).ready(function() {
//Add an arrow and expand the pop-out menu when a module link in the navigation panel is hovered over
//The selector will be triggered whenever the menu arrow or its pop-out menu is hovered over
	$('nav.admin ul li ul.inactive li.title, nav.admin ul li ul.inactive li.title ~ li').mouseover(function() {
	// Regardles of whether this is the arrow or the pop-out menu we are hovering over, go to its parent, and add an arrow
	// to the menu and show the pop-out menu
		$(this).parent().children('.title').addClass('hover').next().addClass('hover');
	}).mouseout(function() {
	// Regardles of whether this is the arrow or the pop-out menu we are hovering over, go to its parent, and remove arrow
	// from the menu and hide the pop-out menu
		$(this).parent().children('.title').removeClass('hover').next().removeClass('hover');
	});
});