/**
 * File: bootstrap.js
 * Desc: bootstraps all bits and pieces of JS
 * Author: markozjovanovic@gmail.com	
 * Date: Dec. 2011
 */
 
$(window).load(function() {
	DropDownMenu();
	filterSlide();
	$("#slider-search").slider({ from: 1, to: 5000, step: 10, smooth: true, round: 0, dimension: " €", skin: "eStore" });
	$("#slider-filter").slider({ from: 1, to: 5000, step: 10, smooth: true, round: 0, dimension: " €", skin: "eStore" });
	$("input, textarea, select, button").uniform();
	$('#slider').nivoSlider();
});