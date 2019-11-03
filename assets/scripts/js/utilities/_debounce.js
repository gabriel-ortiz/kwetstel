/**
 * .debounce() function
 *
 * Source: https://davidwalsh.name/javascript-debounce-function
 */
if (!window.KW) {
	window.KW = {};
}


// ES6 code
var throttled = function(delay, fn) {
	let lastCall = 0;
	return function (...args) {
		const now = (new Date).getTime();
		if (now - lastCall < delay) {
			return;
		}
		lastCall = now;
		return fn(...args);
	}
};

window.KW.throttled = throttled;
module.exports = throttled;