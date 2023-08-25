/**
 *
 * Menu Sections
 *
 * UI for showing the page sections inside the menu
 */
const $ = require("jquery");

var Sections = function (el) {
	//setup some variables
	this.$el = $(el);
	this.$sections = this.$el.find(".kw-c-menu__section-page");
	this.$activeSection = this.$el.find(
		".kw-c-menu__section-page.menu-section--active"
	);
	this.$close = this.$el.find("#kw-c-menu__sections-close");
	this.$pageCTA = $(document).find(".js-section-toggle");

	this.$target = null;
	this.targetId = null;
	this.targetSection = null;

	this.init();
};

Sections.prototype.init = function () {
	// do something
	this.events();
};

Sections.prototype.events = function () {
	this.$pageCTA.on("click", this.event__handleShowSection.bind(this));
	this.$close.on("click", this.event__handleClose.bind(this));
};

Sections.prototype.event__handleShowSection = function (event) {
	event.preventDefault();

	this.target = $(event.currentTarget);
	this.targetId = this.target.data("trigger");
	var isActive = this.target.hasClass("sections--active");

	if (isActive) {
		return;
	}

	this.$el.addClass("kw-c-menu-sections--active");
	$(".menu-section--active").removeClass("menu-section--active");
	$(".section--active").removeClass("section--active");

	this.targetSection = this.$sections.filter((key, el) => {
		return parseInt($(el).attr("data-menu")) === parseInt(this.targetId);
	});

	this.target.addClass("section--active");
	this.targetSection.addClass("menu-section--active");
};

Sections.prototype.event__handleClose = function (event) {
	event.preventDefault();

	console.log(event);

	this.$el.removeClass("kw-c-menu-sections--active");
};

$(document).ready(function () {
	$(".kw-c-menu__sections").each(function () {
		new Sections(this);
	});
});
