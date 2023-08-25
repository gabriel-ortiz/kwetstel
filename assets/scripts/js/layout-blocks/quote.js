/**
 *
 * Quote
 *
 * UI for quote
 */

const $ = require("jquery");
require("waypoints/lib/jquery.waypoints");

var QuoteUI = function (el) {
	this.$el = $(el);
	this.$quoteText = this.$el.find(".kw-c-quote__body > p");
	this.Waypoint;
	this.init();
};

QuoteUI.prototype.init = function () {
	this.Waypoint = new Waypoint({
		element: this.$quoteText,
		handler: function (direction) {
			//console.log( this.element );

			$(this.element).addClass("quote-is-active");

			this.destroy();
		},
		offset: "50%",
	});
};

$(document).ready(function () {
	$(".kw-c-quote").each(function () {
		new QuoteUI(this);
	});
});
