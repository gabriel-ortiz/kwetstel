const       $ = require( 'jquery' );
const slick   = require( 'slick-carousel');
const throttled = require( '../utilities/_debounce' );

var Carousel = function(el){

	this.$el = $(el);
	this.globalDefaults = {
		//mobileFirst     : true,
		//infinite        : true,
		slidesToScroll  : 1,
		//autoplay        : true,
		autoplaySpeed   : 5000,
		pauseOnDotsHover: true,
		dots            : true,
		arrows          : false,
		pauseOnHover    : true,
	};

	this.init();

};

Carousel.prototype.init = function() {
	var data = this.$el.attr('data-slick'),
		options =  (typeof  data !== 'undefined') ? JSON.parse( data ) : {};

	// options.responsive = [];
	//
	// if ( data.optionsSm ) {
	// 	options.responsive.push({
	// 		breakpoint: Foundation.MediaQuery.get('small'),
	// 		settings: data.optionsSm
	// 	});
	// }
	// if ( data.optionsMd ) {
	// 	options.responsive.push({
	// 		breakpoint: Foundation.MediaQuery.get('medium'),
	// 		settings: data.optionsMd
	// 	});
	// }
	// if ( data.optionsLg ) {
	// 	options.responsive.push({
	// 		breakpoint: Foundation.MediaQuery.get('large'),
	// 		settings: data.optionsLg
	// 	});
	// }

	options = $.extend( this.globalDefaults, options );

	//console.log( options );

	var carousel = this.$el.slick(options),
		that = this;

	carousel.on('beforeChange', function(event, slick, currentSlide, nextSlide){
		that.$el.find('.slick-slide').removeClass('kw-is-past');
		that.$el.find('.slick-slide[data-slick-index="'+nextSlide+'"]').prevAll().addClass('kw-is-past');
	});

	$(document).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
		carousel.slick('setPosition');
	});

	$(window).on('resize orientationchange', throttled( 250, function(){

		carousel[0].slick.refresh();

	} ));
};

$(document).ready(function(){
	$('.js-promo-carousel').each(function(){
		new Carousel(this);
	});
});

// Initialize dynamic block preview (editor).
if( window.acf ) {

	//addAction for full width Slider
	window.acf.addAction( 'render_block_preview/type=kw-carousel', function( el, props ){

		$(el).find('.js-promo-carousel').each(function(){
			new Carousel( this );
		});
	} );


}