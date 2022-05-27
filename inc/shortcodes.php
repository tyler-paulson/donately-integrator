<?php

function di_donately_shortcode($atts = [], $content = null, $tag = '') {
    
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $wporg_atts = shortcode_atts(
        array(
            'title' => 'Campaigns',
        ), $atts, $tag
    );

    $campaigns = get_donately_campaigns();
 
    // start box
    $o = '<div class="wporg-box">';
 
    // title
    $o .= '<h2>' . esc_html__( $wporg_atts['title'], 'wporg' ) . '</h2>';
 
    // enclosing tags
    if ( ! is_null( $content ) ) {
        // secure output by executing the_content filter hook on $content
        $o .= apply_filters( 'the_content', $content );
 
        // run shortcode parser recursively
        $o .= do_shortcode( $content );
    }
 
    // end box
    $o .= '</div>';
 
    // return output
    return $o;
}
 
/**
 * Central location to create all shortcodes.
 */
function di_shortcodes_init() {
    add_shortcode( 'donately', 'di_donately_shortcode' );
}
 
add_action( 'init', 'di_shortcodes_init' );