<?php
/*
Plugin Name:       geo2arc wp snipplets
Plugin URI:        https://github.com/geo2arc/geo2arc-wp
Description:       Wordpress snipplets and functions
Version:           1.0.4
Author:            Georgia Georgala
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
Domain Path:       /languages
Text Domain:       geo2arc-wp
GitHub Plugin URI: https://github.com/geo2arc/geo2arc-wp
GitHub Branch:     master
*/

/*--- # PLUGIN: Register Scripts & Styles ---*/

function geo2arc_register_scripts() {
	if (!is_admin()) {
		wp_register_script('geo2arc_script', plugins_url('js/script.js', __FILE__));
		wp_enqueue_script('geo2arc_script');
	}
}
function geo2arc_register_styles() {
	wp_register_style('geo2arc_style', plugins_url('css/style.css', __FILE__));
	wp_enqueue_style('geo2arc_style');
}
add_action('wp_print_scripts', 'geo2arc_register_scripts');
add_action('wp_print_styles', 'geo2arc_register_styles');

/*--- # CONTENT: Limit text length by number of words (fitya) ---*/

function text_limit_by_words($text, $wordscount, $moretext) {
	$limited_text = wp_trim_words( $text, $num_words = $wordscount, $more = $moretext ); 
	echo $limited_text;
}

/*
example: limit post title length to 11 words with ...  limit_words(get_the_title(), 11, ' ...')
reference: http://codex.wordpress.org/Function_Reference/wp_trim_words
**/

/*--- # TIME: Convert Seconds to Time  hh:mm:ss (fitya) ---*/

function sec2hms ($sec, $padHours = true) {
    $hms = "";
    $hours = intval(intval($sec) / 3600);
	if ($hours > 0) :
    $hms .= ($padHours) 
          ? str_pad($hours, 1, "", STR_PAD_LEFT). ":"
          : $hours. ":";
	endif;
    $minutes = intval(($sec / 60) % 60);
	if ($minutes <= 9 &&  $hours <= 0) :
    $hms .= str_pad($minutes, 1, "0", STR_PAD_LEFT). ":";
	else :
	$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
	endif;
	// uncomment to display leading zero in minutes
 	/*	if ($minutes <= 9 && $hours < 0) :
	$hms .= str_pad($minutes, 1, "0", STR_PAD_LEFT). ":";
	endif; */
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}

/* 
usage: store time (like video duration) as seconds and display it in readable form hh:mm:ss
example: echo sec2hms - (get_post_meta($post->ID,'videolength',true))
reference:  http://www.laughing-buddha.net/php/sec2hms 
**/

/*--- # TIME: Convert Unix to Seconds (fitya) ---*/

 function covsecs($youtube_time){
    $start = new DateTime('@0'); // Unix epoch
	if ( $youtube_time !='' ):
		$start->add(new DateInterval($youtube_time));
	endif;
    return $start->format('U');
}

/*
usage: get video length from youtube video (stored in unix) and save it to a field as seconds
example: inside function that saves youtube api video data to custom fields - $new_videolength_value = covsecs($yt_duration);
**/


/* FILTERS */

/*--- # FILTERS: FacetWP Pre-filter on archive page  (fitya, tgc, ecodomisi, geo2arc) ---*/

add_filter( 'facetwp_template_use_archive', '__return_true' );
// https://facetwp.com/documentation/facetwp_template_use_archive/


/*--- # FILTERS: Sort Panel (fitya, tgc) ---*/

function filters_sort_panel($atts) {	
	$sc_atts = shortcode_atts( array(
		'after_counts' => '',
		'classes_out' => '',
		'classes_in' => ''
    ), $atts );
	ob_start();
		echo '<div id="sort-panel" class="' . $sc_atts['classes_out'] . '">';
		echo  '<div class="' . $sc_atts['classes_in'] . '">';
		echo do_shortcode( '[facetwp counts="true"]' );
		echo  '<span> &nbsp;' . $sc_atts['after_counts'] . '&nbsp;  &nbsp; &nbsp;</span>';
		echo do_shortcode( '[facetwp sort="true"]' );
		echo  '&nbsp; &nbsp; &nbsp;';
		echo do_shortcode( '[facetwp selections="true"]' );
	echo   '</div></div>';
	//return $output;
	 return ob_get_clean();
}
add_shortcode( 'filters-sort-panel', 'filters_sort_panel' );

/*--- FILTERS: Pagination - Custom (tgc, ecodomisi ,geo2arc) ---*/

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


/*--- FIELDS: Relationship Field - Bidirectional (fitya) ---*/

function bidirectional_acf_update_value( $value, $post_id, $field  ) {
	$field_name = $field['name'];
	$global_name = 'is_updating_' . $field_name;
	if( !empty($GLOBALS[ $global_name ]) ) return $value;
	$GLOBALS[ $global_name ] = 1;
	if( is_array($value) ) {
		foreach( $value as $post_id2 ) {
			$value2 = get_field($field_name, $post_id2, false);
			if( empty($value2) ) {				
				$value2 = array();				
			}
			if( in_array($post_id, $value2) ) continue;
			$value2[] = $post_id;
			update_field($field_name, $value2, $post_id2);			
		}	
	}	
	$old_value = get_field($field_name, $post_id, false);	
	if( is_array($old_value) ) {
		foreach( $old_value as $post_id2 ) {
			if( is_array($value) && in_array($post_id2, $value) ) continue;
			$value2 = get_field($field_name, $post_id2, false);
			if( empty($value2) ) continue;
			$pos = array_search($post_id, $value2);
			unset( $value2[ $pos] );
			update_field($field_name, $value2, $post_id2);			
		}		
	}
	$GLOBALS[ $global_name ] = 0;
    return $value;  
}

/*
usage: Turn relationship field to bidirectional relationship
example: add_filter('acf/update_value/name=channel_rel', 'bidirectional_acf_update_value', 10, 3);
reference: http://www.advancedcustomfields.com/resources/bidirectional-relationships/
**/

