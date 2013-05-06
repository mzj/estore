/**
 * File: bootstrap.js
 * Desc: bootstraps all bits and pieces of JS after page finished loading
 * Author: markozjovanovic@gmail.com	
 * Date: Dec. 2011
 */
 
$(window).load(function() {
        // Category drop down menu in the header
        dropDownMenu();
        // Uniform form style
	$("input, textarea, select, button").uniform();
        // NivoSlider needs to be initialized before Slider Range 
        // Absolute positioning conflict 
	$('#slider').nivoSlider();
        // LightBox
        $(".lightbox").lightbox({
            fitToScreen: true,
            imageClickClose: false
        });
        // Slider - Price Range
        priceRangeSlider();
        // Main app
        productsApp();
});