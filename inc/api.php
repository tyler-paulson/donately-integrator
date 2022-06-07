<?php

function get_donately($endpoint, $query = array(), $args = array()) {
    error_log('Requesting data from Donately');
    $query['account_id'] = DONATELY_ID;
    $url = DONATELY_API_BASE . $endpoint . '?'. http_build_query($query);
    if(!isset($args['headers'])) {
        $args['headers'] = array();
    }
    $args['headers']['Authorization'] = base64_encode(DONATELY_TOKEN);
    $args['headers']['Accept'] = 'application/json';
    $args['headers']['Donately-Version'] = DONATELY_API_VERSION;
    $get = wp_safe_remote_get($url, $args);
    return json_decode($get['body'])->data;
}

function get_donately_campaigns() {

    $transient = 'di_get_donately_campaigns';
    $expiration = intval(DI_TRANSIENT_EXPIRATION);

    $campaigns = get_transient($transient);

    if(!$campaigns) {

        $query = array(
            'status' => 'published'
        );
    
        $campaigns = get_donately('campaigns', $query);

        set_transient($transient, $campaigns, $expiration);

    }
    

    //el($campaigns);

    return sort_donately($campaigns);

}