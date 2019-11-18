/**
 *
 * Menu
 *
 * UI for show the menu parts
 */

const $ = require('jquery');

var Menu = function(el){
	this.init();
};

Menu.prototype.init = function(){
	// do something
};

$(document).ready(function(){
	$('#menu-wrapper').each(function(){
		new Menu(this);
	});

});