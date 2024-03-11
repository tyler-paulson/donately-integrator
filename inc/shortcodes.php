<?php

function campaign_html($c, $hl, $w) {
    $o = '';
    $o .= '<li class="di-c">';
    $o .= '<a href="'.$c->url.'/donate">';
    $o .= '<header>';
    $o .= '<h'.($hl+1).' class="di-c_title">'.$c->title.'</h'.($hl+1).'>';
    if(!empty($c->images->photo->original)) {
        $o .= '<img src="'.$c->images->photo->original.'" width="316" class="di-c_image">';
    } else {
        if(strpos($w, 'dark') !== false) {
            $o .= '<img src="'.DI_PLUGIN_URL.'images/placeholder-dark.svg" width="316" class="di-c_image">';
        } else {
            $o .= '<img src="'.DI_PLUGIN_URL.'images/placeholder.svg" width="316" class="di-c_image">';
        }
    }
    $o .= '</header>';
    if(!empty($c->description)) {
        $o .= '<p class="di-c_description">'.$c->description.'</p>';
    }
    $o .= '</a>';
    $o .= '</li>';
    return $o;
}

// https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/

function di_donately_shortcode($atts = [], $content = null, $tag = '') {  

    $gutenberg = true;
    
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $ov_atts = shortcode_atts(
        array(
            'title' => 'Campaigns',
            'heading' => '3',
            'wrapper' => '',
            'featured' => '',
            'skip' => '',
            'all' => in_array('all', $atts)
        ), $atts, $tag
    );

    $hl = intval($ov_atts['heading']);

    $wrapper_class = 'di di-wrap donately';

    if($gutenberg) {
        $wrapper_class .= ' alignwide';
    }

    $wrapper_class .= ' '.$ov_atts['wrapper'];
 
    // start box
    $o = '<div class="'.$wrapper_class.'">';
 
    // title
    if(!empty($ov_atts['title'])) {
        $o .= '<h'.$hl.' class="di-title">' . esc_html__( $ov_atts['title'], 'wporg' ) . '</h'.$hl.'>';
    }
    
    // enclosing tags
    if ( ! is_null( $content ) ) {

        $o .= '<div class="di-content">';

        // secure output by executing the_content filter hook on $content
        $o .= apply_filters( 'the_content', $content );
        
        $o .= '</div>';
    }

    $campaigns = get_donately_campaigns($ov_atts['featured'], $ov_atts['skip']);

    $categories = array();

    $other_count = 0;

    foreach($campaigns as $c) {
        if(!empty($c->category)) {
            if(!in_array($c->category, $categories)) {
                array_push($categories, $c->category);
            }
        } else {
            $other_count ++;
        }
    }

    if(count($categories) > 0) {
        if($ov_atts['all']) {
            // Add 'All' at the beginning of $categories array
            array_unshift($categories, 'All');
        }
        $o .= '<ul class="di-categories" style="display:none;">';
        foreach($categories as $cat) {
            $o .= '<li><button class="di-cat_filter">'.$cat.'</button></li>';
        }
        if($other_count > 0) {
            $o .= '<li><button class="di-cat_filter">Other</button></li>';
        }
        $o .= '</ul>';
    }

    $campaign_list_classes = 'di-list';

    $o .= '<div class="di-campaigns">';

    if(count($categories) > 0) {
        if($ov_atts['all']) {
            $o .= '<ul class="'.$campaign_list_classes.'" data-category="All">';
            foreach($campaigns as $c) {
                $o .= campaign_html($c, $hl, $wrapper_class);
            }
            $o .= '</ul>';
        }
        foreach($categories as $cat) {
            $o .= '<ul class="'.$campaign_list_classes.'" data-category="'.$cat.'">';
            foreach($campaigns as $c) {
                if(!empty($c->category) && $c->category === $cat) {
                    $o .= campaign_html($c, $hl, $wrapper_class);
                }  
            }
            $o .= '</ul>';
        }
        if($other_count > 0) {
            $o .= '<ul class="'.$campaign_list_classes.'" data-category="Other">';
            foreach($campaigns as $c) {
                if(empty($c->category)) {
                    $o .= campaign_html($c, $hl, $wrapper_class);
                }
            }
        }
        $o .= '</ul>';
    } else {
        $o .= '<ul class="'.$campaign_list_classes.'">';
        foreach($campaigns as $c) {
            $o .= campaign_html($c, $hl, $wrapper_class);
        }
        $o .= '</ul>';
    }

    $o .= '</div>';
 
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