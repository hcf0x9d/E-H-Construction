// TODO: Annotate the code...
function Slider(imgCont, capCont, dotCont) {
	this.imgCont = imgCont;
	this.capCont = capCont;
	this.dotCont = dotCont;

	this.slides = [];
}

// TODO: Cleanup the Slider code a bit. It's a touch messy.
Slider.prototype.run = function () {
	'use strict';

	var s = this;

	var imgs = document.querySelectorAll('.rotator-images-item');
	var cards = document.querySelectorAll('.rotator-card-captions-item');
	var dots = document.querySelector('.rotator-dots');

	// Set the initial live ones...
	$(dots).children().eq(0).addClass('is-active');
	// dots.children[0].classList += ' is-active';
	$(imgs[0]).addClass('is-active');
	// imgs[0].classList += ' is-active';
	$(cards[0]).addClass('is-active');
	// cards[0].classList += ' is-active';

	// cards[0].parentElement.style.height = cards[0].offsetHeight + 'px';

	var timer = setTimeout(rotate, 5000);
	var i;

	function rotate() {

		i = $('.rotator-card-captions-item.is-active').index();

		if (i + 2 <= s.slides.length) {
			i++;
		} else {
			i = 0;
		}

		rotateView(s.slides[i]);

		timer = setTimeout(rotate, 5000);
	}

	function rotateView (id) {
		var currImg = document.querySelector('.rotator-images-item.is-active');
		var currDot = document.querySelector('.rotator-dots-dot.is-active');
		var currCard = document.querySelector('.rotator-card-captions-item.is-active');

		$(currImg).removeClass('is-active');
		$(currDot).removeClass('is-active');
		$(currCard).removeClass('is-active');

		// currImg.classList = currImg.classList.value.replace(' is-active', '');

		// currDot.classList = currDot.classList.value.replace(' is-active', '');
		// currCard.classList = currCard.classList.value.replace(' is-active', '');
		// console.log(currCard.classList);

		for (var i = 0; i < imgs.length; i++) {

			if (imgs[i].dataset.project.indexOf(id) === 0) {

				// Set the proper image to active (add to DOM / make opacity 1)
				// imgs[i].classList += ' is-active';
				$(imgs[i]).addClass('is-active');
				// Set the proper dot to active (change style)
				// dots.children[i].classList += ' is-active';
				$(dots).children().eq([i]).addClass('is-active');
				// Set the new card's opacity to 0 so we can fade it
				// cards[i].style.opacity = 0;
				$(cards[i]).css('opacity', 0);

				// Add the is-active class to the card which adds it to the DOM
				// cards[i].classList += ' is-active';
				$(cards[i]).addClass('is-active');

				// Set the card container to the current card's height
				cards[i].parentNode.parentNode.style.height = cards[i].offsetHeight + 'px';

				// Set the card's opacity to 1, CSS will add a fade through transition
				cards[i].style.opacity = 1;
			}
		};

	}

	$('.rotator-card').on('mouseenter mouseleave', function (e) {

		if (e.type === 'mouseenter') {
			clearTimeout(timer);
		} else {
			timer = setTimeout(rotate, 5000);
		}
	});

	var dot = document.querySelectorAll('.rotator-dots-dot');
	var len;
	for (i = 0, len = dot.length; i < len; i++) {
		dot[i].addEventListener('click', switchProjectStack);
	}

	function switchProjectStack(event) {

		var clicked = event.target.dataset.project;

		rotateView(clicked);
	}

};

// Build an object for each image to be ready...
function ImageObj(name, path, title, caption) {
	this.name = name;
	this.path = path;
	this.title = title;
	this.caption = caption;
}



function Lightbox() {
	lb = this;

	lb.project = document.getElementById('project');
	lb.images = [];

	lb.run = function () {

		var pops = document.querySelectorAll('.lightbox-pop');

		for (var i = 0; i < pops.length; i++) {

			var src = pops[i].attributes.src.value;
			var n = src.lastIndexOf('/');

			var img = new ImageObj(src.substring(n + 1), src.substring(0, n - 3), '', '');

			lb.images.push(img);
		};

		$('body').on('click', function () {
			lb.inputHandler();
		});

	};
}

Lightbox.prototype.open = function (name) {
	var lb = this;

	if ($('.overlay').length <= 0 && $(window).width() > 768) {
		var controls = '<ul class="overlay-controls"><li class="overlay-controls-target mod-left lightbox-pop"></li><li class="overlay-controls-target mod-right lightbox-pop"></li></ul>';

		$('body').append(
			$('<div>', {class: 'shade'})
		).append(
			$('<div>', {class: 'overlay'}).append(
				$('<i>', {class: 'overlay-close', text: '×'})
			).append(
				controls
			)
		);

		$('.shade').animate({
			opacity: 0.7
		}, 150);

		$('.overlay-close').on('click', function () {
			lb.close();
		});
	}
};

Lightbox.prototype.close = function () {
	// Close functions
	$('.overlay').fadeOut(150, function () {
		$('.shade').fadeOut(150, function () {
			$('.overlay, .shade').remove();
		});
	});
};

Lightbox.prototype.changeImage = function (name) {
	var lb = this;

	for (var i = this.images.length - 1; i >= 0; i--) {
		// TODO: Grab the data for this image
		if (this.images[i].name === name) {
			var img = this.images[i];

			if ($('.lightbox-image').length <= 0) {
				$('.overlay').append(
					$('<img>', {class: 'lightbox-image', src: img.path + img.name, style: 'opacity:0'})
				);

				$('.lightbox-image').fadeTo(150, 1);
			} else {
				// TODO: Don't make functions in for loops...
				$('.lightbox-image').fadeTo(150, 0, function () {
					$(this).attr('src', img.path + img.name).fadeTo(150, 1);
				});
			}


			if (i === 0) {
				getNext(i + 1);
				getPrev(lb.images.length - 1);
			} else if (i + 1 === lb.images.length) {
				getNext(0);
				getPrev(i - 1);
			} else {
				getNext(i + 1);
				getPrev(i - 1);
			}
		}
	}

	function getNext(i) {
		$('.overlay-controls-target.mod-right').attr('src', lb.images[i].path + '200/' + lb.images[i].name);
	}

	function getPrev(i) {
		$('.overlay-controls-target.mod-left').attr('src', lb.images[i].path + '200/' + lb.images[i].name);
	}
};

Lightbox.prototype.inputHandler = function () {
	var openTriggers = 'lightbox-pop';
	var closeTriggers = 'lightbox-close';
	var traverseTriggers = 'lightbox-traverse';
	var classArray = event.target.classList.value.split(' ');
	var src, name;

	if (classArray.indexOf(openTriggers) > 0) {
		src = event.target.attributes.src.value;
		name = src.substring(src.lastIndexOf('/') + 1);

		this.open(name);
		this.changeImage(name);

	} else if (classArray.indexOf(closeTriggers) > 0) {
		this.close();
	}

	// else if (e === 'prev' || e === 'next') {
	// 	this.changeImage(e);
	// }
};



function FormMail(selector) {
	this.selector = selector;

	this.data = [];

	this.listen();
}

FormMail.prototype.listen = function () {

	var frm = this;
	var form = document.getElementById(this.selector);

	form.onsubmit = submitForm;

	function submitForm() {
		event.preventDefault();

		frm.data.push($(frm.selector).serialize());

		frm.submit();

		return false;
	}
};

FormMail.prototype.validate = function () {

};

FormMail.prototype.submit = function () {
	var frm = this;
	var note = $('#note');

    $.ajax({
        type: "POST",
        url: "/controllers/ajax.controllers.php",
        data: 'action=mailer&' + frm.data,
        success: function(msg) {
            if ( note.height() ) {
                note.slideUp(250, function() { $(this).hide(); });

            }
            else {
                note.hide();

            }

            $('#form-submit span').empty().append('<i class="fa fa-envelope-o" style="margin-right: 5px;font-size: 1em;"></i>');

            result = '<h1 class="mt-0" style="font-size:2em;">'+msg+'</h1>';

            var i = setInterval(function() {
                if ( !note.is(':visible') ) {
                    note.html(result).slideDown(250);
                    clearInterval(i);
                }
            }, 40);
        }
    });


	// AJAX this.data
	console.log(this);
};
// Mail function moves to here...