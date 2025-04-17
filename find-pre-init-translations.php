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

add_filter( 'gettext', function( $translated, $text, $domain ) {

    // Only log if debugging is turned on.
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG === false ) {
        return $translated;
    }

    // If we've already passed init, bail.
    if ( did_action( 'init' ) ) {
        return $translated;
    }

    // Skip core ('default') translations.
    if ( 'default' === $domain ) {
        return $translated;
    }

    // Capture a short backtrace.
    $bt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 5 );
    $caller = null;

    foreach ( array_slice( $bt, 3 ) as $frame ) {
        if ( empty( $frame['file'] ) ) {
            continue;
        }
        // Skip WP core files or this plugin file itself.
        if ( false !== strpos( $frame['file'], 'wp-includes/' )
          || false !== strpos( $frame['file'], 'wp-admin/' )
          || false !== strpos( $frame['file'], basename( __FILE__ ) )
        ) {
            continue;
        }
        $caller = $frame;
        break;
    }

    $location = $caller
        ? "{$caller['file']} on line {$caller['line']}"
        : 'unknown location';

    // Find the hook name that called gettext.
    global $wp_current_filter;
    $filters = $wp_current_filter;
    $hook    = isset( $filters[ count( $filters ) - 2 ] )
             ? $filters[ count( $filters ) - 2 ]
             : '(none)';

    $log = sprintf(
        'Pre Init Translations - hook="%s"; text="%s"; domain="%s"; location="%s";',
        $hook,
        $text,
        $domain,
        $location
    );

    if ( defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY === true ) {
        echo '<br>'.$log.'<br>';
    }

    error_log( $log );

    return $translated;
}, 0, 3 );
