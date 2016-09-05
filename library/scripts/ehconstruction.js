var Slider = function (imgCont, capCont, dotCont) {
	this.imgCont = imgCont;
	this.capCont = capCont;
	this.dotCont = dotCont;
	this.fullScreen = true;

	this.slides = [];

	if (this.fullScreen === true) {
		document.getElementsByTagName('html')[0].style.background = '#414b4e';
	}
};

Slider.prototype.run = function () {
	'use strict';

	var s = this;

	var imgs = document.querySelectorAll('.rotator-images-item');
	var cards = document.querySelectorAll('.rotator-card-captions-item');
	var dots = document.querySelector('.rotator-dots');

	// console.log(cards[0].parentElement.style);

	// Set the initial live ones...
	dots.children[0].classList += ' is-active';
	imgs[0].classList += ' is-active';
	cards[0].classList += ' is-active';

	cards[0].parentElement.style.height = cards[0].offsetHeight;

	// TODO: Show first items
	(function rotateCore(i) {

		if (i === s.slides.length) {
			i = 1;
		} else if (i < s.slides.length) {
			i++;
		}

		setTimeout(function () {
			rotateView(s.slides[i - 1]);
			rotateCore(i);
		}, 5000);

	}(0));

	function rotateView (id) {
		var currImg = document.querySelector('.rotator-images-item.is-active');
		var currDot = document.querySelector('.rotator-dots-dot.is-active');
		var currCard = document.querySelector('.rotator-card-captions-item.is-active');

		currImg.classList = currImg.classList.value.replace(' is-active', '');

		currDot.classList = currDot.classList.value.replace(' is-active', '');
		currCard.classList = currCard.classList.value.replace(' is-active', '');
		// console.log(currCard.classList);
		imgs.forEach(function (v, i) {
			if (imgs[i].dataset.project.indexOf(id) === 0) {

				imgs[i].classList += ' is-active';

				dots.children[i].classList += ' is-active';

				cards[i].classList += ' is-active';

				cards[i].parentNode.parentNode.style.height = cards[i].offsetHeight + 'px';

			}
		});


		// TODO: Get next item, fade out previous, fade in the new
	}
};

var sliderSet = new Slider('rotator-images-item', 'rotator-card-captions-item', 'rotator-dots');
var slideData = document.querySelectorAll('.rotator-card-captions-item');

slideData.forEach(function (v, i) {

	sliderSet.slides.push(v.dataset.project);

});

sliderSet.run();