jQuery(document).ready(function($) {
	

/*--------------------------------------------------------------
# Filters: FacetWP Filters Accordion Menu (fitya, tgc)
--------------------------------------------------------------*/

// prevent page from jumping to top from  # href link
$('.menu-top-menu-container li.menu-item-has-children > a').click(function(e) {
		e.preventDefault();
});

// remove link from menu items that have children
$(".menu-top-menu-container li.menu-item-has-children > a").attr("href", "#");

//  open / close menu items (thegiftcentral)

$(".facetwp-facet-product_categories > .facetwp-checkbox").click(function(e) {
	e.preventDefault();
	$(this).toggleClass('open');
		var link = $(this);
		var closest_ul = link.next(".facetwp-facet-product_categories");
		var parallel_active_links = closest_ul.find(".active")
		var closest_li = link.closest('.facetwp-depth');
		var link_status = closest_li.hasClass("active");
		var count = 0;

		closest_ul.find(".facetwp-depth").slideUp(function() {
				if (++count == closest_ul.find(".facetwp-depth").length)
						parallel_active_links.removeClass("active");
		});

		if (!link_status) {
				closest_li.children(".facetwp-depth").slideDown();
				closest_li.addClass("active");
		}

})

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


/*--------------------------------------------------------------
# Filters: FacetWP Infinite Scroll (fitya)
--------------------------------------------------------------*/

$('#loaded').hide();

window.fwp_is_paging = false;

$(document).on('facetwp-refresh', function() {
	if (! window.fwp_is_paging) {
		window.fwp_page = 1;
		FWP.extras.per_page = 'default';
	}

	window.fwp_is_paging = false;
});

$('body.archive').on('facetwp-loaded', function() {
	window.fwp_total_rows = FWP.settings.pager.total_rows;

	if (! FWP.loaded) {
		window.fwp_default_per_page = FWP.settings.pager.per_page;

		$(window).scroll(function() {
			if ($(window).scrollTop() == $(document).height() - $(window).height()) {
				var rows_loaded = (window.fwp_page * window.fwp_default_per_page);
				if (rows_loaded < window.fwp_total_rows) {
					window.fwp_page++;
					window.fwp_is_paging = true;
					FWP.extras.per_page = (window.fwp_page * window.fwp_default_per_page);
					FWP.soft_refresh = true;
					$('#loaded').hide();
					$('#loading').show();
					setInterval(function() {$('#loading').hide();}, 4000);
					FWP.refresh();
					
				} else { $('#loaded').show(); }
			}
		});
	}
});

/*
usage: after content create divs #loading, #loaded style="display:none;"
reference: https://facetwp.com/infinite-scroll-with-facetwp/
**/


}); //jQuery
