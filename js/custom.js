/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {


//  Newsletter popup cookie
// ________________________________________	
// if($("#homepage-flag").length > 0) {
// 	if (document.cookie.indexOf('visited=true') == -1) {
// 		var fifteenDays = 1000*60*60*24*15;
// 		var expires = new Date((new Date()).valueOf() + fifteenDays);
// 		document.cookie = "visited=true;expires=" + expires.toUTCString();
		
// 			$('.newsletter').animate({ "max-width": "80%" }, 'fast');
// 	}
// }
// //  Close the modal
// // ________________________________________	
// $('.close').click(function() {
// 	$(this).parent('.newsletter').animate({ "max-width": "0" }, 'fast');
// });
// $('.nothanks').click(function() {
// 	$(this).parent('.newsletter').animate({ "max-width": "0" }, 'fast');
// });

 /*if (document.cookie.indexOf('visited=true') == -1) {
	var fifteenDays = 1000*60*60*24*15;
	var expires = new Date((new Date()).valueOf() + fifteenDays);
	document.cookie = "visited=true;expires=" + expires.toUTCString();
	$.colorbox({width:"60%", inline:true, href:"#mc_embed_signup"});
}*/
	
// 		Newsletter Signup
// ________________________________________
/*$(".newsletter").colorbox({
	inline:true, width:"60%",
	className:'newsletter'
 });*/

/*
		Sticky Nav
__________________________________________
*/	
	

	$(window).scroll(function() {
		var  mn = $(".head-contents");
    	mns = "head-contents-scrolled";
    	hdr = $('.head-contents').height();

	  if( $(this).scrollTop() > hdr ) {
		mn.addClass(mns);
		$('.sd-content').addClass('social-fixed');
		//mns.animate({"opacity":"1"}, 1000);
	  } else {
		//mn.removeClass(mns);
		mn.removeClass(mns);
		$('.sd-content').removeClass('social-fixed');
		//mns.animate({"opacity":"0"}, 1000);
	  }
	});	

	$('.sd-content').addClass('social-float');
	$(window).scroll(function() {

	  if( $(this).scrollTop() > 500 ) {
		$('.sd-content').addClass('social-fixed');
		$('.sd-content').removeClass('social-float');
	  } else {
		$('.sd-content').removeClass('social-fixed');
		$('.sd-content').addClass('social-float');
	  }
	});	

	// $(window).scroll(function() {
		
	//   if( $(this).scrollTop() > 500 ) {
	// 	$('.sd-content')addClass('social-fixed');
	// 	$('.sd-content')removeClass('social-float');
	//   } else {
	// 	$('.sd-content').removeClass('social-fixed');
	// 	$('.sd-content').addClass('social-float');
	//   }
	// });	
		
		// Make active current page
	$("[href]").each(function() {
    if (this.href == window.location.href) {
        $(this).addClass("active");
        }
	});
	
	
	// Flexslider
	// front page slider 
/*	$('.flexslider').flexslider({
		animation: "slide",
	}); // end register flexslider*/
	
	// Colorbox
	$('a.gallery').colorbox({
		rel:'gal',
		width: '80%', 
		height: '80%'
	});
	
	//Isotope with images loaded ...
	var $container = $('#container').imagesLoaded( function() {
  	$container.isotope({
    // options
	 itemSelector: '.item',
		  masonry: {
			gutter: 15
			}
 		 });
	});
	
	
	// Equal heights divs
	$('.blocks').matchHeight();
	$('.js-titles').matchHeight();
	/*var byRow = $('body').hasClass('test-rows');
		$('.blocks-container').each(function() {
		 $(this).children('.blocks').matchHeight({
			   byRow: byRow
		//property: 'min-height'
		});
	});*/


	    // Relocate Jetpack sharing buttons down into the comments form
	   // jQuery( '#sharing' ).html( jQuery( '.sharedaddy' ).detach() );

	
	

	(function() {

      // store the slider in a local variable
      var $window = $(window),
          flexslider;

      // tiny helper function to add breakpoints
      function getGridSize() {
        return (window.innerWidth < 600) ? 1 :
               (window.innerWidth < 900) ? 3 : 4;
      }

      $(function() {
        SyntaxHighlighter.all();
      });

      $window.load(function() {
        $('.flexslider').flexslider({
          animation: "slide",
		   controlNav:false,
          animationSpeed: 400,
          animationLoop: false,
          itemWidth: 250,
          itemMargin: 5,
          minItems: getGridSize(), // use function to pull in initial value
          maxItems: getGridSize(), // use function to pull in initial value
          start: function(slider){
            $('body').removeClass('loading');
            flexslider = slider;
          }
        });
      });

      // check grid size on resize event
      $window.resize(function() {
        var gridSize = getGridSize();

        flexslider.vars.minItems = gridSize;
        flexslider.vars.maxItems = gridSize;
      });
    }());


    /*
	*
	*	Make first word in date underlined
	*
	------------------------------------*/
	 $('.js-first-word').each(function(index, element) {
        var heading = $(element);
        var word_array, last_word, first_part;

        word_array = heading.html().split(/\s+/); // split on spaces
        last_word = word_array.shift();             // shift the first word
        first_part = word_array.join(' ');        // rejoin the first words together

        heading.html(['<span class="e-date">', last_word, '</span> ' , first_part].join(''));
    });

	 /*
	*
	*	Make first word in date underlined
	*
	------------------------------------*/
	 $('.js-first-word-uppercase').each(function(index, element) {
        var heading = $(element);
        var word_array, last_word, first_part;

        word_array = heading.html().split(/\s+/); // split on spaces
        last_word = word_array.shift();             // shift the first word
        first_part = word_array.join(' ');        // rejoin the first words together

        heading.html(['<span class="uppercase">', last_word, '</span> ' , first_part].join(''));
    });

    var $video_wrapper = $('.template-video .video-holder .video-wrapper');
    if($video_wrapper.length>0){
        var $window = $(window);
        var $video_holder = $('.template-video .video-holder');
        var $site_nav = $('#site-navigation');
        function video_check(){
            var anchor = $video_holder.offset().top;
            var offset_y = 10;
            var offset_x = 10;
            if($site_nav.length>0){
                offset_y = offset_y + $site_nav.height();
            }
            if($window.scrollTop()>anchor && window.innerWidth > 600){
                $video_wrapper.css({
                    position:'fixed',
                    top: offset_y + "px",
                    right: offset_x+"px",
                    width: '250px',
                    height: '250px'
                });
            } else {
                $video_wrapper.css({
                    position:'',
                    top: '',
                    right: '',
                    width: '',
                    height: ''
                });
            }
        }
        video_check();
        $window.on("scroll",video_check);
        $window.on("resize",video_check);
    }
});// END #####################################    END Document Ready

