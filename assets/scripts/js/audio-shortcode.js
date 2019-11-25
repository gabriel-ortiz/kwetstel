/**
 *
 * Audio Shortcode
 *
 * UI for playing the audio for the shortcode
 */

const $ = require('jquery');

var Audio = function(el){

	this.$el        = $(el);
	this.$audio     = this.$el.find('.kw-c-play-audio-id');
	this.$cta       = this.$el.find('.kw-c-play-audio__cta');

	this.init();
};

Audio.prototype.init = function(){
	// do something
	this.events();
};

Audio.prototype.events = function(){

	this.$cta.on('click', this.event__handlePlay.bind(this) );
};

Audio.prototype.event__handlePlay = function(event){

	event.preventDefault();

	this.$audio[0].pause();
	this.$audio[0].currentTime = 0;
	this.$audio[0].play();

	// if (this.$audio[0].paused) {
	// 	this.$audio[0].play();
	// }else{
	// 	this.$audio[0].pause();
	// 	this.$audio[0].currentTime = 0
	// }
};

$(document).ready(function(){
	$('.kw-c-play-audio').each(function(){
		new Audio(this);
	});

});