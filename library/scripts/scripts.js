function setNav(){

    var urlParts = window.location.pathname.split('/');
    var pathname = urlParts[1];

    var nav = document.querySelectorAll('.nav-target');

    nav.forEach(function (v, i) {

        if (nav[i].attributes.href.value === '/' + pathname) {
            nav[i].classList += ' is-current';
        }
    });
}


function fullheight(e){
    var bodyheight = $(window).height();
    jQuery('.'+e).height(bodyheight);
}

function lightbox(e){
    var p = $('h1#project').text();
    var t = $('#ProjectGallery img[src="'+e+'"]').data('title');
    var c = $('#ProjectGallery img[src="'+e+'"]').data('caption');
    var next = $('#ProjectGallery img[src="'+e+'"]').parent('li').next().children('img').attr('src');
    var prev = $('#ProjectGallery img[src="'+e+'"]').parent('li').prev().children('img').attr('src');

    //var e = e.split('/');
    var e = e.replace('200/','');
    var full = new Image();

    function preload()
    {
        // Show the shade/preloader
        var $shade = '<div id="shade"></div>';
        $($shade).hide().appendTo('body').fadeIn(250);
        // hide the scroll bars
        //$('html').css('overflow-y','scroll');
        //$("body").css({ "height" : ($(window).height() - 1) + 'px', "overflow": "hidden" });

        full.src = e;
        full.onload = openLightbox;
    }

    function openLightbox()
    {
        var h = $(window).height();
        // construct the lightbox
        var $lightboxbox = '<div id="lightboxbox" style="background:url(/images/ajax-loader.gif) center center no-repeat;">\
                                <img src="/images/close.png" class="pos-a pos-ne-corner" style="padding:20px;cursor:pointer" onClick="closeLightbox();" />\
                                <i id="prev-btn" class="fa fa-angle-left pos-a anim" style="left:10px;top:50%;font-size:2em;" onClick="changeImage(\''+prev+'\');"></i>\
                                <div class="lb-imgwrap" style="height:'+h+'px;">\
                                    <img id="full-image" src="'+full.src+'" alt="" style="max-width:100%;max-height:100%;margin:0 auto;" />\
                                </div>\
                                <i id="next-btn" class="fa fa-angle-right pos-a anim" style="right:10px;top:50%;font-size:2em;" onClick="changeImage(\''+next+'\');"></i>\
                            </div>';
        /*

        //Removed the info card temporarily
        <div class="infoBox card p-20 pos-se-corner pos-a" style="width:200px;margin:20px;">\
            <h2 class="helper mt-0 mb-5" style="font-size:1em;">'+p+'</h2>\
            <h2 class="c-outer-space mb-0 mt-0 little-line futura-book">'+t+'</h2>\
            <p class="mt-0 mb-0 c-natural-gray">'+c+'</p>\
        </div>\
        */
        // show the lightbox
        $($lightboxbox).hide().appendTo('body').delay(100).fadeIn(250);
        if(!prev){
            $('#prev-btn').hide();
        } else {
            $('#prev-btn').show();
        }

        if(!next){
            $('#next-btn').hide();
        } else {
            $('#next-btn').show();
        }
    }

    preload();
}

function changeImage(e){
    var next = $('#ProjectGallery img[src="'+e+'"]').parent('li').next().children('img').attr('src');
    var prev = $('#ProjectGallery img[src="'+e+'"]').parent('li').prev().children('img').attr('src');

    var e = e.replace('200/','');
    var full = new Image();

    full.src = e;
    full.onload = switchImage;

    function switchImage(){
        $('#full-image').fadeTo(250,0, function(){
            $(this).attr('src', full.src);
            $('#next-btn').attr('onClick', 'changeImage(\''+next+'\');')
            $('#prev-btn').attr('onClick', 'changeImage(\''+prev+'\');')
        }).fadeTo(250, 1);

        if(!prev){
            $('#prev-btn').hide();
        } else {
            $('#prev-btn').show();
        }

        if(!next){
            $('#next-btn').hide();
        } else {
            $('#next-btn').show();
        }
    }
}

function closeLightbox(){
    $('#shade, #lightboxbox').fadeOut(250).empty();
    //$('html').css('overflow-y','auto');
    //$("body").css({ "height" : 'auto'});
}