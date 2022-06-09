<?php

function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'donation-integrator', DI_PLUGIN_URL . 'css/front.css', array(), null );
}

add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );