jQuery(document).ready(function($) {

/*--------------------------------------------------------------
# Filters: FacetWP Filters Accordion Menu (fitya)
--------------------------------------------------------------*/

// prevent page from jumping to top from  # href link
$('.menu-top-menu-container li.menu-item-has-children > a').click(function(e) {
		e.preventDefault();
});

// remove link from menu items that have children
$(".menu-top-menu-container li.menu-item-has-children > a").attr("href", "#");

//  open / close menu items
$(".facet-title").click(function() {
	$(this).toggleClass('open');
		var link = $(this);
		var closest_ul = link.closest(".facet-menu");
		var parallel_active_links = closest_ul.find(".active")
		var closest_li = link.closest('.facet-dropdown');
		var link_status = closest_li.hasClass("active");
		var count = 0;

		closest_ul.find(".facetwp-type-checkboxes").slideUp(function() {
				if (++count == closest_ul.find(".facetwp-type-checkboxes").length)
						parallel_active_links.removeClass("active");
		});

		if (!link_status) {
				closest_li.children(".facetwp-type-checkboxes").slideDown();
				closest_li.addClass("active");
		}
})



}); //jQuery
