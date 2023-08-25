/**
 *
 * Sidebar
 *
 * Actions for handling the sidebar functionality in pages
 */


const $     = require( 'jquery' );

var SidebarUI = function(el){

	this.$el            = $(el);
	this.$contents      = this.$el.find( '.kw-c-sidebar__inner' );
	this.$triggers      = $( document ).find( '[data-sidebar-open]' );


	this.init();
};

SidebarUI.prototype.init = function(){

	this.validateContent();

	// do something
	this.events();
};

SidebarUI.prototype.events = function(){

	this.$triggers.on( 'click', this.event__handleTrigger.bind(this) );

};

SidebarUI.prototype.event__handleTrigger = function( event ){

	event.preventDefault();

	const $target   = $(event.currentTarget );
	const href      = $target.attr('href');
	const entry     = this.$el.find( href );

	console.log( href, entry );


	try{

		this.$contents.not( entry ).hide();

		entry.show();

		if( !this.$el.hasClass( 'is-open' ) ){

			this.$el.foundation( 'open' );
		}

	}catch (e) {

		console.log( e );

	}

};

SidebarUI.prototype.validateContent = function(){

	this.$triggers.each( (index, el)=>{
		const $el       = $(el);
		const href      = $el.attr('href');
		const entry     = this.$el.find( href );

		if( ! entry.length ){
			$el.removeClass( 'has-content' )
			.replaceWith(function () {
					return $('<span/>', {
						html: $(this).text()
					});
			});


		}
	} );

};

$(document).ready(function(){
	$('.kw-c-sidebar ').each(function(){
		new SidebarUI(this);
	});

});