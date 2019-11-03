/**
 *
 * Greensock Animations
 *
 *  UI file for creating greensock animations
 */

const $     = require( 'jquery' );

var _gsap = {};

	_gsap.self_slideup__onload = function(el){

		const $el = $(el);

		TweenMax.to(
			$el,
			1,
			{
				autoAlpha: 1,
				y: 0,
				ease: Back.easeOut.config(3),
				lazy: true
			}
		);

	};


$(document).ready(function(){
	$('.js-e-gsap__self-slideup--onload').each(function(){
		new _gsap.self_slideup__onload(this);
	});

});


module.exports = _gsap;