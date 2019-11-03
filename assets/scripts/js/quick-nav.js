/**
 *
 * Quick Nav
 *
 * UI for showing the current block in the header on scroll
 */

const $ = require( 'jquery' );


var QuickNav = function(el){

	this.$el            = $(el);
	this.$blocks        = $(document).find( '.kw-c-block, #page-hero' );
	this.$quickNavAnchor = this.$el.find('.kw-c-quick-nav__item-text');
	this.$quickNavItems = this.$quickNavAnchor.find( 'span' );
	this.$dropDownList  = this.$el.find( '#dropdown-block-list' );

	//init the dropdown list
	this.QuickList  = new Foundation.Dropdown( this.$dropDownList, { parentClass: 'kw-c-quick-nav__wrapper', alignment: 'bottom', position: 'left', closeOnClick: true } );
	//console.log( this.QuickList );


	this.init();
};

QuickNav.prototype.init = function(){
	// do something

	const config = {
		rootMargin: '0px 0px -85%',
	};

	const observer = new IntersectionObserver((entries) => {

		console.log( entries );

		entries.forEach(entry => {

			if (entry.isIntersecting ) {

				var $entryId    = entry.target.id;
				var $activeEl   = this.$quickNavAnchor.find( `[data-target=${$entryId}]` );

				console.log( $entryId, $activeEl );

				this.$quickNavItems.removeClass( 'kw-is-active' );
				$activeEl.addClass('kw-is-active');

			}
		});
	}, config);

	this.$blocks.get().forEach(image => {
		observer.observe(image);
	});
};

$(document).ready(function(){
	$('.kw-c-quick-nav').each(function(){
		new QuickNav(this);
	});

});