<?php

// https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/

function di_donately_shortcode($atts = [], $content = null, $tag = '') {

    $gutenberg = true;
    
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $ov_atts = shortcode_atts(
        array(
            'title' => 'Campaigns',
        ), $atts, $tag
    );

    $wrapper_class = 'di di-wrap donately';

    if($gutenberg) {
        $wrapper_class .= ' alignwide';
    }
 
    // start box
    $o = '<div class="'.$wrapper_class.'">';
 
    // title
    if(!empty($ov_atts['title'])) {
        $o .= '<h3>' . esc_html__( $ov_atts['title'], 'wporg' ) . '</h3>';
    }
    
    // enclosing tags
    if ( ! is_null( $content ) ) {

        $o .= '<div class="do-content">';

        // secure output by executing the_content filter hook on $content
        $o .= apply_filters( 'the_content', $content );
        
        $o .= '</div>';
    }

    $campaigns = get_donately_campaigns();

    foreach($campaigns as $c) {
        $o .= '<h4>'.$c->title.'</h4>';
        $o .= '<h5>'.$c->category.'</h4>';
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