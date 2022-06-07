<?php

function sort_donately($campaigns) {

    usort($campaigns, function($a, $b){

        $a_full_title = $a->title;
        $a_position_of_seperator = stripos($a_full_title, DI_CATEGORY_SEPERATOR);
        $a_seperated_title = substr($a_full_title, $a_position_of_seperator + strlen(DI_CATEGORY_SEPERATOR));

        $b_full_title = $b->title;
        $b_position_of_seperator = stripos($b_full_title, DI_CATEGORY_SEPERATOR);
        $b_seperated_title = substr($b_full_title, $b_position_of_seperator + strlen(DI_CATEGORY_SEPERATOR));
        
        return $a_seperated_title <=> $b_seperated_title;

    });

    foreach($campaigns as $key => $c) {
        error_log($c->title);
    }

    $featured = null;

    foreach($campaigns as $key => $c) {
        if($c->id === DI_DONATELY_FEATURED) {
            $featured = $c;
            unset($campaigns[$key]);
        }
    }

    if(!is_null($featured)) {
        $campaigns = array($featured) + $campaigns;
    }

    foreach($campaigns as &$c) {

        $full_title = $c->title;
        $position_of_seperator = stripos($full_title, DI_CATEGORY_SEPERATOR);
        $seperated_title = substr($full_title, $position_of_seperator + strlen(DI_CATEGORY_SEPERATOR));
        
        $category = substr($c->title, 0, $position_of_seperator);

        $c->title = $seperated_title;
        $c->category = $category;
    }

    return $campaigns;

}