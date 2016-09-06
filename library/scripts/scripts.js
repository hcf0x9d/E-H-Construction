function rotatorInit(){
    // Initialize and set the first items
    $('#rotator-images li:first-child, .rotator-captions li:first-child, .rotator-dots li:first-child').addClass('current');
    timer = setTimeout(function(){
        rotate();
    }, 5000);
}

function rotateContent(group){
    // Variables
    var $currImage = $('#rotator-images li.current');
    var $newImage = $('#rotator-images li[data-group="group'+group+'"]');

    var $currCap = $('.rotator-captions li.current');
    var $newCap = $('.rotator-captions li[data-group="group'+group+'"]');

    var $currDot = $('.rotator-dots li.current');
    var $newDot = $('.rotator-dots li[data-selector="'+group+'"]');

    // Change the image
    if ($currImage.data('group') != $newImage.data('group'))
    {
        $currImage.fadeOut(200, function(){
            $newImage.addClass('current').siblings().removeClass('current');
        });
        $newImage.fadeIn(200);
    }

    // Change the captions
    $currCap.fadeOut(0, function(){
        $newCap.addClass('current').siblings().removeClass('current');
        $('.rotator-captions li.current').fadeIn(0);
    });

    // Change the dot
    $newDot.addClass('current').siblings().removeClass('current');

    timer = setTimeout(function(){
        rotate();
    }, 5000);
}

function rotate(){
    var $nextGroup = $('.rotator-dots li.current').next().data('selector');

    if($nextGroup == undefined){
        $first = $('.rotator-dots li:first-child').data('selector');

        rotateContent($first);
    } else {
        rotateContent($nextGroup);
    }
}

function setNav(){

    var pathname = window.location.pathname;
    var pathname = pathname.split('/');
    var pathname = pathname[1];

    var $navEl = $('nav a');

    $navEl.each(function(){
        var $href = $(this).attr('href');
        var $href = $href.split('/');
        var $href = $href[1];

        if(pathname == $href)
        {
            $(this).addClass('current');
        }
        if(pathname == 'project'){
            $('a[href="/projects"]').addClass('current');
        }
        if(pathname == 'update'){
            $('a[href="/updates"]').addClass('current');
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

/*svgmagic*/
(function($){$.fn.svgmagic=function(givenoptions){var defaultoptions={preloader:false,testmode:false,secure:false,callback:false,backgroundimage:false,dumpcache:false};var options=$.extend(defaultoptions,givenoptions);var preloaderTimer=[];if(options.testmode||!document.createElement("svg").getAttributeNS){if(typeof JSON=="undefined"){if(typeof JSON!=="object"){JSON={}}(function(){"use strict";function f(e){return e<10?"0"+e:e}function quote(e){escapable.lastIndex=0;return escapable.test(e)?'"'+e.replace(escapable,function(e){var t=meta[e];return typeof t==="string"?t:"\\u"+("0000"+e.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+e+'"'}function str(e,t){var n,r,i,s,o=gap,u,a=t[e];if(a&&typeof a==="object"&&typeof a.toJSON==="function"){a=a.toJSON(e)}if(typeof rep==="function"){a=rep.call(t,e,a)}switch(typeof a){case"string":return quote(a);case"number":return isFinite(a)?String(a):"null";case"boolean":case"null":return String(a);case"object":if(!a){return"null"}gap+=indent;u=[];if(Object.prototype.toString.apply(a)==="[object Array]"){s=a.length;for(n=0;n<s;n+=1){u[n]=str(n,a)||"null"}i=u.length===0?"[]":gap?"[\n"+gap+u.join(",\n"+gap)+"\n"+o+"]":"["+u.join(",")+"]";gap=o;return i}if(rep&&typeof rep==="object"){s=rep.length;for(n=0;n<s;n+=1){if(typeof rep[n]==="string"){r=rep[n];i=str(r,a);if(i){u.push(quote(r)+(gap?": ":":")+i)}}}}else{for(r in a){if(Object.prototype.hasOwnProperty.call(a,r)){i=str(r,a);if(i){u.push(quote(r)+(gap?": ":":")+i)}}}}i=u.length===0?"{}":gap?"{\n"+gap+u.join(",\n"+gap)+"\n"+o+"}":"{"+u.join(",")+"}";gap=o;return i}}if(typeof Date.prototype.toJSON!=="function"){Date.prototype.toJSON=function(){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+f(this.getUTCMonth()+1)+"-"+f(this.getUTCDate())+"T"+f(this.getUTCHours())+":"+f(this.getUTCMinutes())+":"+f(this.getUTCSeconds())+"Z":null};String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(){return this.valueOf()}}var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={"\b":"\\b","	":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},rep;if(typeof JSON.stringify!=="function"){JSON.stringify=function(e,t,n){var r;gap="";indent="";if(typeof n==="number"){for(r=0;r<n;r+=1){indent+=" "}}else if(typeof n==="string"){indent=n}rep=t;if(t&&typeof t!=="function"&&(typeof t!=="object"||typeof t.length!=="number")){throw new Error("JSON.stringify")}return str("",{"":e})}}if(typeof JSON.parse!=="function"){JSON.parse=function(text,reviver){function walk(e,t){var n,r,i=e[t];if(i&&typeof i==="object"){for(n in i){if(Object.prototype.hasOwnProperty.call(i,n)){r=walk(i,n);if(r!==undefined){i[n]=r}else{delete i[n]}}}}return reviver.call(e,t,i)}var j;text=String(text);cx.lastIndex=0;if(cx.test(text)){text=text.replace(cx,function(e){return"\\u"+("0000"+e.charCodeAt(0).toString(16)).slice(-4)})}if(/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){j=eval("("+text+")");return typeof reviver==="function"?walk({"":j},""):j}throw new SyntaxError("JSON.parse")}}})()}var obj=this,images=[],domimages=[],cssimages=[];obj.each(function(){if($(this).attr("src")!=undefined){if($(this).attr("src").split(".").pop()=="svg"||$(this).attr("src").substr(0,18)=="data:image/svg+xml"){$obj=$(this);var e=new Image;e.src=$(this).attr("src");images.push(e.src);domimages.push($obj);if(options.preloader!=false){preloaderTimer.push(setTimeout(function(){$obj.attr("src",options.preloader)},500))}}}});if(options.backgroundimage){obj.each(function(){if($(this).css("background-image")!="none"&&$(this).css("background-image")!=undefined){var e=$(this).css("background-image").replace(/^url\(["']?/,"").replace(/["']?\)$/,"");if(e.split(".").pop()=="svg"){var t=new Image;t.src=e;images.push(t.src);cssimages.push($(this))}}})}var data={svgsources:images,secure:options.secure,dumpcache:options.dumpcache};if(images.length>0){var i=0;$.ajax({dataType:"json",method:"POST",url:"http://svgmagic.bitlabs.nl/converter.php",data:data,success:function(e){var t;for(t=0;t<domimages.length;t++){clearTimeout(preloaderTimer[t]);domimages[t].attr("src",e.results[t].url)}if(options.backgroundimage){for(t;t<domimages.length+cssimages.length;t++){var n=t-domimages.length;cssimages[n].css("background-image",'url("'+e.results[t].url+'")')}}if(options.callback){options.callback()}}})}}}})(jQuery)