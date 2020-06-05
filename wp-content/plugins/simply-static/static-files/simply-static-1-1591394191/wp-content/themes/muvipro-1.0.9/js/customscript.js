/*
 * Copyright (c) 2016 Gian MR
 * Gian MR Theme Custom Javascript
 */
 
var $ = jQuery.noConflict();

(function( $ ) {
	/* http://www.w3schools.com/js/js_strict.asp */
	"use strict";
	
	jQuery(function($) {
		/* Sidr Resposive Menu */
		$('#gmr-responsive-menu').sidr({
			name: 'menus',
			source: '.gmr-mainmenu',
			displace: false
		});
		$( window ).resize(function() {
			$.sidr('close', 'menus');
		});
		$('#sidr-id-close-menu-button').click(function(e){
			e.preventDefault();
			$.sidr('close', 'menus');
		});
		
		$('#gmr-secondaryresponsive-menu').sidr({
			name: 'secondmenus',
			source: '.gmr-secondmenu',
			displace: false
		});
		$( window ).resize(function() {
			$.sidr('close', 'secondmenus');
		});
		$('#sidr-id-close-secondmenu-button').click(function(e){
			e.preventDefault();
			$.sidr('close', 'secondmenus');
		});
		
		$('#gmr-topnavresponsive-menu').sidr({
			name: 'topnavmenus',
			source: '.gmr-topnavmenu',
			displace: false
		});
		$( window ).resize(function() {
			$.sidr('close', 'topnavmenus');
		});
		$('#sidr-id-close-topnavmenu-button').click(function(e){
			e.preventDefault();
			$.sidr('close', 'topnavmenus');
		});
		
	}); /* End jQuery(function($) { */
		
	/* Accessibility Drop Down Menu */
	jQuery(function($) {
		$('.menu-item-has-children a').focus( function () {
			$(this).siblings('.sub-menu').addClass('focused');
		}).blur(function(){
			$(this).siblings('.sub-menu').removeClass('focused');
		});
		// Sub Menu
		$('.sub-menu a').focus( function () {
			$(this).parents('.sub-menu').addClass('focused');
		}).blur(function(){
			$(this).parents('.sub-menu').removeClass('focused');
		});
	}); /* End jQuery(function($) { */
	
	/* Sticky Menu */
	jQuery(function($) {
		$(window).scroll(function() {
			if ( $(this).scrollTop() > 325 ) {
				$('.top-header').addClass('sticky-menu');
			} else {
				$('.top-header').removeClass('sticky-menu');
			}
		});
	}); /* End jQuery(function($) { */
	
	/* Match Height */
	jQuery(function($) {
		$('.gmr-box-content, .gmr-item-modulepost img').matchHeight({
			byRow: true,
			property: 'height',
			target: null,
			remove: false
		});
	}); /* End jQuery(function($) { */
	
	/* Magnific Popup */
	jQuery(function($) {
		$('.gmr-trailer-popup').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-img-mobile mfp-no-margins mfp-with-zoom',
			removalDelay: 160,
			preloader: false,
			zoom: {
				enabled: true,
				duration: 300
			}
		});
	}); /* End jQuery(function($) { */

	/* Switch Player */
	jQuery(function($) {
		$(".gmr-switch-button").click(function(){		
			$('.tab-content').addClass('relative-video');
			$("#lightoff").fadeToggle();
		});	
		
		$('#lightoff').click(function(){
			$('.tab-content').removeClass('relative-video');
			$('#lightoff').hide();
		});	
	}); /* End jQuery(function($) { */
	
	/* Scroll to top */
	jQuery(function($) {
		var ontop = function(){
			var st = $(window).scrollTop();		
			if(st < $(window).height())	
				$('.gmr-ontop').hide();
			else
				$('.gmr-ontop').show();
		}
		$(window).scroll(ontop);
		$('.gmr-ontop').click(function(){
		  $('html, body').animate({scrollTop:0}, 'normal');
			return false;
		});
	}); /* End jQuery(function($) { */
	
})(jQuery);

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();