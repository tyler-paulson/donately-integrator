<?php

/*
Plugin Name: Donately Integrator
Description: Integrates Donately campaigns into a page 
Version:     0.0.1
Author:      Tyler Paulson
Author URI:  https://work.tylerpaulson.com
License:     GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) or die('No script kiddies please!');

define('DI_DB_VERSION', '1'); // Incorporate this later: https://wordpress.stackexchange.com/a/144873/162024

define('DI_TRANSIENT_EXPIRATION', '1800');

defined('DONATELY_API_BASE') or define('DONATELY_API_BASE', 'https://api.donately.com/v2/');
defined('DONATELY_API_VERSION') or define('DONATELY_API_VERSION', '2018-04-01');

require_once 'inc/activation.php';
require_once 'inc/api.php';
require_once 'inc/helper.php';
require_once 'inc/options-page.php';
require_once 'inc/shortcodes.php';

register_deactivation_hook( __FILE__, 'di_delete_all_transients');
