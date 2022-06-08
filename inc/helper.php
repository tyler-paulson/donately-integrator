<?php

if (function_exists('el')) {
    function el($var) {
        error_log(print_r($var, true));
    }
} 
