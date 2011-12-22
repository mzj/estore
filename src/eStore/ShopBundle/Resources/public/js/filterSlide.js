/**
 *
 */
 
function filterSlide() {
	$("#filter-close").click(function() {
		// Slide up and down filter form
		$("#filter-container form").stop(true, true).slideToggle(500);
		
		// Responsible for changeing arrow button
		var down = $("#filter-collapse-btn").attr('src') == "/bundles/estoreshop/img/arrow-down.png";
		$("#filter-collapse-btn").attr(
			'src', 
			$("#filter-collapse-btn").attr('src').replace(down ? '-down' : '-up', down ? '-up' : '-down')
		);		
	});
}
 