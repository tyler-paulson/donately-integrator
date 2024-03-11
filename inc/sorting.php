<?php

function pluralize($cat) {
    if($cat === 'Fundraiser') {
        return $cat . 's';
    }
    return $cat;
}

function explode_title($full_title) {

    $position_of_seperator = stripos($full_title, DI_CATEGORY_SEPERATOR);
    $seperated_title = substr($full_title, $position_of_seperator + strlen(DI_CATEGORY_SEPERATOR));

    $category = substr($full_title, 0, $position_of_seperator);

    return array(
        'category' => $category,
        'title' => $seperated_title
    );

}

function sort_donately($campaigns, $featured = '', $skip = '') {

    usort($campaigns, function($a, $b){
        
        $a_exploded = explode_title($a->title);
        $b_exploded = explode_title($b->title);
        
        return $a_exploded['title'] <=> $b_exploded['title'];

    });

    foreach($campaigns as $key => $c) {
        if($c->id === $featured) {
            $featured = $c;
            unset($campaigns[$key]);
        } else if($c->id === $skip) {
            unset($campaigns[$key]);
        }
    }

    if(!empty($featured)) {
        $campaigns = array($featured) + $campaigns;
    }

    foreach($campaigns as &$c) {

        $exploded = explode_title($c->title);

        $c->title = $exploded['title'];
        $c->category = pluralize($exploded['category']);

    }

    return $campaigns;

}