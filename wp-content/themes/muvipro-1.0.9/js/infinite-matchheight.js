/*
 * Copyright (c) 2016 Gian MR
 * Gian MR Theme Custom Javascript
 */
 
var $ = jQuery.noConflict();

(function( $ ) {
	/* http://www.w3schools.com/js/js_strict.asp */
	"use strict";
	
	// infinite scroll jetpack working with match height
	jQuery(function($) {
		$( document.body ).on( 'post-load', function () {
			$('.gmr-box-content').matchHeight({ byRow: false });
			$('.gmr-trailer-popup').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-img-mobile mfp-no-margins mfp-with-zoom',
				removalDelay: 160,
				preloader: false,
				zoom: {
					enabled: true,
					duration: 300
				}
			});
		});
	}); /* End jQuery(function($) { */
	
})(jQuery);