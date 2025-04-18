<?php
/**
 * Plugin Name:       Find Pre Init Translations
 * Plugin URI:        https://github.com/jaimelias/find-pre-init-translations
 * Description:       Logs all gettext() calls triggered before the init hook for non‑default domains, helping developers identify translation-order issues and resolve the "Function _load_textdomain_just_in_time was called incorrectly." error.
 * Version:           1.0.0
 * Author:            jaimelias
 * Author URI:        https://jaimelias.com/
 * License:           GPL‑2.0+
 * Text Domain:       find-pre-init-translations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


require_once plugin_dir_path( __FILE__ ) . 'hook-gettext.php';
require_once plugin_dir_path( __FILE__ ) . 'hook-load-textdomain.php';

?>