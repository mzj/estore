/**
 * File: bootstrap.js
 * Desc: bootstraps all bits and pieces of JS
 * Author: markozjovanovic@gmail.com	
 * Date: Dec. 2011
 */
 
$(window).load(function() {
	dropDownMenu();
        productsApp();
	//$("#slider-search").slider({ from: 1, to: 5000, step: 10, smooth: true, round: 0, dimension: " €", skin: "eStore" });
	//$("#slider-filter").slider({ from: 1, to: 5000, step: 10, smooth: true, round: 0, dimension: " €", skin: "eStore" });
	$("input, textarea, select, button").uniform();
	$('#slider').nivoSlider();
        
        
        $( "#slider-range" ).slider({
            range: true,
            min: 1,
            max: 1000,
            values: [ 1, 1000 ],
            slide: function( event, ui ) {
                var offset1 = $("#slider-range").children('.ui-slider-handle').first().offset();
                var offset2 = $("#slider-range").children('.ui-slider-handle').last().offset();
                $(".tooltip1").css('top',offset1.top - 15).css('left',offset1.left).show();
                $(".tooltip2").css('top',offset2.top - 15).css('left',offset2.left).show();

                $(".tooltip1").text(ui.values[ 0 ] + "");
                $(".tooltip2").text(ui.values[ 1 ] + "");
            }
        });

        $( "#slider-range" ).bind( "slidechange", function(event, ui) {
            var priceMin =  ui.values[ 0 ]
            var priceMax =  ui.values[ 1 ]
            console.log( "Min: " + priceMin + " Max: " + priceMax );
        });

        var offset1 = $("#slider-range").children('.ui-slider-handle').first().offset();
        var offset2 = $("#slider-range").children('.ui-slider-handle').last().offset();
        $(".tooltip1").css('top',offset1.top - 15).css('left',offset1.left);
        $(".tooltip2").css('top',offset2.top - 15).css('left',offset2.left);

        $(".tooltip1").text($("#slider-range").slider("values", 0) + "");
        $(".tooltip2").text($("#slider-range").slider("values", 1) + "");
});