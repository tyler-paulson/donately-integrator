<?php

function di_options_page() {
    add_options_page(
        'Donately Options',
        'Donately',
        'manage_options',
        'di',
        'di_options_page_html'
    );
}

add_action('admin_menu', 'di_options_page');

function di_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <p>Add your Donately Account Unique ID as constant named DONATELY_ID in wp-config.php or functions.php.</p>
        <p>Add your Donately API Token as constant named DONATELY_TOKEN in wp-config.php or functions.php.</p>
        <p>They both can be accessed on your <a href="https://dashboard.donately.com/integrations/api" target="_blank">Donately Dashboard</a>.</p>
    </div>
    <?php
}