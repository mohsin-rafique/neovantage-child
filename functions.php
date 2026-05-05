<?php
/**
 * NEOVANTAGE Child theme functions.
 *
 * @package NEOVANTAGE_Child
 */

declare(strict_types=1);

/**
 * Enqueue the child stylesheet on top of the parent's.
 *
 * The parent theme already registers its main stylesheet with the handle
 * `neovantage` (see neovantage/functions.php). The child only needs to enqueue
 * its own style.css and depend on that handle — re-enqueueing the parent's
 * style.css here would cause it to be loaded twice.
 *
 * @since 1.1.0
 */
function neovantage_child_enqueue_styles(): void {
	wp_enqueue_style(
		'neovantage-child',
		get_stylesheet_uri(),
		array( 'neovantage' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'neovantage_child_enqueue_styles' );

/**
 * Load the child theme textdomain.
 *
 * Translations can be added to the /languages/ directory.
 *
 * @since 1.1.0
 */
function neovantage_child_setup(): void {
	load_child_theme_textdomain( 'neovantage-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'neovantage_child_setup' );
