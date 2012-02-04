function priceRangeSlider() {        
        //Slider - Price Range
        $( "#slider-range" ).slider({
            range: true,
            min: 1,
            max: 1000,
            values: [ 1, 1000 ],
            slide: function( event, ui ) {
                priceRangeUpdate(ui);
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

        $(".tooltip1").text($("#slider-range").slider("values", 0) + "\u20AC");
        $(".tooltip2").text($("#slider-range").slider("values", 1) + "\u20AC");
        
        function priceRangeUpdate(ui) {
            var offset1 = $("#slider-range").children('.ui-slider-handle').first().offset();
            var offset2 = $("#slider-range").children('.ui-slider-handle').last().offset();
            $(".tooltip1").css('top',offset1.top - 15).css('left',offset1.left);
            $(".tooltip2").css('top',offset2.top - 15).css('left',offset2.left);
            if(ui) {
                $(".tooltip1").text(ui.values[ 0 ] + "\u20AC");
                $(".tooltip2").text(ui.values[ 1 ] + "\u20AC");    
            } else {
                $(".tooltip1").text($("#slider-range").slider("values", 0) + "\u20AC");
                $(".tooltip2").text($("#slider-range").slider("values", 1) + "\u20AC"); 
            }
        }
        
        priceRangeUpdate();
}