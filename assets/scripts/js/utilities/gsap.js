/**
 *
 * Greensock Animations
 *
 *  UI file for creating greensock animations
 */

const $ = require("jquery");
const gsap = require("gsap/gsap-core");

const _gsap = {};

_gsap.self_slideup__onload = function (el) {
	const $el = $(el);

	gsap.to($el, 1, {
		autoAlpha: 1,
		y: 0,
		ease: Back.easeOut.config(3),
		lazy: true,
	});
};

$(function () {
	$(".js-e-gsap__self-slideup--onload").each(function () {
		new _gsap.self_slideup__onload(this);
	});
});
