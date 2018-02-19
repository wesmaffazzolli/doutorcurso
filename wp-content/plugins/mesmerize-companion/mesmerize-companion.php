<?php
/* 
 *	Plugin Name: Mesmerize Companion
 *  Author: Horea Radu
 *  Description: The Mesmerize Companion plugin adds drag and drop page builder functionality to the Mesmerize theme.
 *
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Version: 1.2.6
 */

// Makse sure that the companion is not already active from another theme
if ( ! defined("MESMERIZE_COMPANION_AUTOLOAD")) {
    require_once __DIR__ . "/vendor/autoload.php";
    define("MESMERIZE_COMPANION_AUTOLOAD", true);
}

Mesmerize\Companion::load(__FILE__);
add_filter('mesmerize_is_companion_installed', '__return_true');