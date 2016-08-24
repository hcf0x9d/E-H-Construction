// The home page stuff (content rotator)

var Slide = function () {
	this.title = '';
	this.summary = '';
	this.cover = '';
	this.url = '';
};

var slideSet = function () {
	console.log('hi');

	var slides = $.ajax({
		url: '/controllers/ajax.controllers.php',
		data: {'action': 'test'},
		type: 'post',
		success: function (response) {
			// Returns the json response from an echo
			console.log(response);

			return response;
		},
		error: ''
	});

	console.log(slides);
	// TODO: AJAX function that returns a list of slides in JSON
	// [
	// 	{
	// 		title: {String},
	// 		summary: {String},
	// 		cover: {String},
	// 		url: {String}
	// 	},
	// ]
};

var SlideController = function () {

};

$(function () {
	slideSet();
});