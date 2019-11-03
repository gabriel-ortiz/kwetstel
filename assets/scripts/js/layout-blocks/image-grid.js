/**
 * Every piece of UI that requires javascript should have its own
 * javascript file. Use this file as a template for structuring
 * all JS source files.
 *
 * {Title}
 *
 * {Description}
 */

const $ = require( 'jQuery' );


var ImgGrid = function(el){

	this.$el           = $(el);
	this.$wrapper      = this.$el.find( '.kw-c-block__wrapper' );
	this.groupName     = this.$wrapper.attr( 'id' );

	//console.log( this.groupName );


	this.init();
};

ImgGrid.prototype.init = function(){
	// do something
};

$(document).ready(function(){
	$('.kw-c-img-grid').each(function(){
		new ImgGrid(this);
	});

});