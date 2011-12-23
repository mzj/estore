/**
 * File: dropDownMenu.js
 * Desc: Infinite depth - multi level horizontal drop down menu
 * Source: http://www.catchmyfame.com
 * Edited for the purpose of eStore by: markozjovanovic@gmail.com
 * Date: Dec. 2011
 */

function DropDownMenu() {
	// .selected-nav
	// how to best handle the widths of the various menus?
	// In IE, the top level LIs dont get the right border applied until the mouseover and not at all
	// if there's no child list (UL). Setting the CSS in the HTML fixes this (why?).
	$('#nav').css({'list-style':'none','padding':'0'});
	$('#nav ul').css({'position':'absolute','list-style':'none','padding':'0', 'background' : '#fff url(/bundles/estoreshop/img/dropdown-menu-gradient.png) bottom repeat-x'});
	$('#nav li').css({'padding':'4px','position':'relative','cursor':'pointer'}); // style the menu items
	$('#nav li li').addClass("menuitem"); // is width necessary? how can we customize the widths better?
	$('#nav li ul').addClass("menu");
        
	$('ul ul').each(function() {
		$('> li:last',this).addClass('roundedbottom');
		$(this).addClass('roundedbottom');
	});

	overlap = 5;
	
	paddingOffset = parseInt($('#nav li').css('paddingRight'))+parseInt($('#nav li').css('paddingLeft'));
	borderOffset = parseInt($('#nav > li ul').css('border-left-width'));
	navWidth = ($('#nav > li').width() * $('#nav > li').length) + (paddingOffset * $('#nav > li').length) + (borderOffset * $('#nav > li').length - 1);

	// Styling top-level items
	$('#nav').css({'height':paddingOffset+$('#nav > li').height()+'px','width':navWidth}),
	$('#nav > li').css({'text-align':'center','float':'left'}); // center the top level menu content
	$('#nav > li:last').css({'border-right':'none'});

	$('#nav li li').hover(
		function() {
			$(this).css('backgroundColor','#faa')
		},
		function() {
			$(this).css('backgroundColor','')
		}
	);
		
	// hide all lists except the top level
	$('#nav ul').hide();

	// when hovering over the top level list items, bring the immediate child into proper left position
	$('#nav > li:has(ul)').hover(function() {
			$('> ul',this)
			.css({'left':-borderOffset+'px','top':$('#nav li').height()+paddingOffset+'px'})
			.stop(true, true)
			.hide()
			.fadeIn(100);
		},
		function() {
			$('> ul',this).fadeOut(100);
		}
	);
	
	$('#nav ul li:has(ul)').css('background','url(/bundles/estoreshop/img/arrow-right.png) no-repeat 98% 50%');
	//$('#nav ul li:has(ul)').css('background-color','#fff');
	$('#nav ul li:has(ul)').hover(
		function() {
			paddingOffset = parseInt($('#nav li').css('paddingRight'))+parseInt($('#nav li').css('paddingLeft'));
			
			// If IE, add in border to paddingOffset. using opacity here because it tells IE apart from other browsers
			paddingOffsetFix = (!jQuery.support.opacity) ? paddingOffset + (borderOffset * 2):paddingOffset;
	
			if($(this).css('z-index')=='auto') $(this).css('z-index',1);
			if($(this).offset().left + $(this).width()*2 >= $(document).width()) paddingOffsetFix=-$(this).width()*2;
			$(this).children().css({'left':$(this).width()+paddingOffsetFix-overlap+'px','top':-borderOffset+'px'}).stop(true, true).hide().fadeIn(100);
		},
		function() { // problem when adding links as this alters the hierarchy. specifcy target
			$(this).children('ul').fadeOut(100);
		}
	);
}