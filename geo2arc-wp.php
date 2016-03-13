<?php
/*
Plugin Name:       geo2arc wp snipplets
Plugin URI:        https://github.com/geo2arc/geo2arc-wp
Description:       Wordpress snipplets and functions
Version:           1.0.0
Author:            Georgia Georgala
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
Domain Path:       /languages
Text Domain:       geo2arc-wp
GitHub Plugin URI: https://github.com/geo2arc/geo2arc-wp
GitHub Branch:     master
*/

/*--------------------------------------------------------------
# Plugin: Register Scripts & Styles
--------------------------------------------------------------*/

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

/*--------------------------------------------------------------
# Text: Limit text length by number of words (fitya)
--------------------------------------------------------------*/

function text_limit_by_words($text, $wordscount, $moretext) {
	$limited_text = wp_trim_words( $text, $num_words = $wordscount, $more = $moretext ); 
	echo $limited_text;
}

/*
example: limit post title length to 11 words with ...  limit_words(get_the_title(), 11, ' ...')
reference: http://codex.wordpress.org/Function_Reference/wp_trim_words
**/

/*--------------------------------------------------------------
# Time: Convert Seconds to Time  hh:mm:ss (fitya)
--------------------------------------------------------------*/

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

/*--------------------------------------------------------------
# Time: Convert Unix to Seconds (fitya)
--------------------------------------------------------------*/

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

/*--------------------------------------------------------------
# Filters: FacetWP Sort Panel (fitya, tgc)
--------------------------------------------------------------*/

function filters_sort_panel($after_counts, $classes_out, $classes_in) {
	ob_start();
	echo '
	<div id="sort-panel" class="' . $classes_out .'">
		<div class="' . $classes_in .'">';
		echo do_shortcode( '[facetwp counts="true"]' );
		echo '<span>' . $after_counts . '  &nbsp; &nbsp;</span>';
		echo do_shortcode( '[facetwp sort="true"]' );
		echo '&nbsp; &nbsp; &nbsp;';
		echo do_shortcode( '[facetwp selections="true"]' );
	echo '</div></div>';
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'filters-sort-panel', 'filters_sort_panel' );
