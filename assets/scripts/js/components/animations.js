const $ = require("jquery");
const gsap = require("gsap");

var Animations = function (el) {
	this.init();
};

Animations.prototype.init = function () {
	$(".js-e-gsap__self-slideup--onload").each(function () {
		gsap.gsap.to(this, {
			duration: 0.5,
			autoAlpha: 1,
			y: 0,
			ease: "Power1.easeOut",
		});
	});
};

$(function () {
	new Animations();
});
