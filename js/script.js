jQuery(document).ready(function($) {
	

/*--------------------------------------------------------------
# FILTERS: FacetWP Filters Accordion Menu (fitya, tgc)
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
# FILTERS: FacetWP Checkbox Parent (tgc)
--------------------------------------------------------------*/

$(document).on('facetwp-loaded', function() {
	$('.facetwp-depth .facetwp-depth').prev().addClass('has-children');
});

/*--------------------------------------------------------------
FILTERS: Custom Pagination (ecodomisi, tgc)
--------------------------------------------------------------*/

function custom_facetwp_pager( $output, $params ) {
    $output = '';
    $page = (int) $params['page'];
    $total_pages = (int) $params['total_pages'];
	$output .= '<ul class="uk-pagination page-numbers">';
    // Only show pagination when > 1 page
    if ( 1 < $total_pages ) {
        if ( 1 < $page ) {
            $output .= '<li><a class="facetwp-page" data-page="' . ( $page - 1 ) . '">&laquo; Previous</a></li>';
        }
        if ( 3 < $page ) {
            $output .= '<li><a class="facetwp-page first-page" data-page="1">1</a></li>';
            $output .= ' <span class="dots">…</span> ';
        }
        for ( $i = 2; $i > 0; $i-- ) {
            if ( 0 < ( $page - $i ) ) {
                $output .= '<li><a class="facetwp-page" data-page="' . ($page - $i) . '">' . ($page - $i) . '</a></li>';
            }
        }
        // Current page
        $output .= '<li class="uk-active"><span class="facetwp-page active current"><a style="padding:0" data-page="' . $page . '">' . $page . '</a></span></li>';
        for ( $i = 1; $i <= 4; $i++ ) {
            if ( $total_pages >= ( $page + $i ) ) {
                $output .= '<li><a class="facetwp-page" data-page="' . ($page + $i) . '">' . ($page + $i) . '</a></li>';
            }
        }
        if ( $total_pages > ( $page + 4 ) ) {
            $output .= ' <li><span class="dots">…</span></li> ';
            $output .= '<li><a class="facetwp-page last-page" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
        }
        if ( $page < $total_pages ) {
            $output .= '<li><a class="facetwp-page" data-page="' . ( $page + 1 ) . '">Next &raquo;</a></li>';
        }
    }
	
	$output .="</ul>";
    return $output;
}
add_filter( 'facetwp_pager_html', 'custom_facetwp_pager', 10, 2 );

/*
reference: Custom pagination (functions.php) – https://gist.github.com/mgibbs189/9732174
**/

}); //jQuery
