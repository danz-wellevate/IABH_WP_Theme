<?php
/**
 * Theme basic setup
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

add_action( 'after_setup_theme', 'understrap_setup' );

if ( ! function_exists( 'understrap_setup' ) ) {
	function understrap_setup() {
		load_theme_textdomain( 'understrap', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'      => __( 'Primary Menu', 'understrap' ),
				'footer-left'  => __( 'Footer Left Menu', 'understrap' ),
				'footer-right' => __( 'Footer Right Menu', 'understrap' ),
			)
		);

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		add_theme_support(
			'custom-background',
			apply_filters(
				'understrap_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		add_theme_support( 'custom-logo' );
		add_theme_support( 'responsive-embeds' );

		understrap_setup_theme_default_settings();
	}
}

// Register ACF Blocks
require_once get_template_directory() . '/inc/acf-blocks/register.php';

// ACF Theme Options
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
    ));

}

class Primary_Menu_Walker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes );

		// Treat as no-submenu if it has a real URL (not #) despite having children
		$is_real_link = ! empty( $item->url ) && $item->url !== '#';
		$no_submenu   = in_array( 'no-submenu', $classes ) || ( $has_children && $is_real_link );

		$class_names = implode( ' ', array_map( 'esc_attr', $classes ) );

		// Add no-submenu class to the rendered HTML automatically
		if ( $no_submenu && ! in_array( 'no-submenu', $classes ) ) {
			$class_names .= ' no-submenu';
		}

		$output .= $indent . '<li class="' . $class_names . '">';

		$atts  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$atts .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$atts .= ! empty( $item->xfn )        ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$atts .= ! empty( $item->url )        ? ' href="' . esc_url( $item->url ) . '"' : '';

		$output .= '<a' . $atts . '>';
		$output .= esc_html( $item->title );

		// No chevron if it's a real clickable link
		if ( $has_children && ! $no_submenu ) {
			$output .= '<svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none">
  <path d="M-4.84004e-07 0.92728L-4.04163e-08 11.0754C-4.44981e-09 11.8982 1.06248 12.3096 1.68532 11.7268L6.42983 7.28697C7.19006 6.57558 7.19006 5.41849 6.42983 4.7071L1.68532 0.267312C1.06248 -0.306945 -5.1997e-07 0.104464 -4.84004e-07 0.92728Z"/>
</svg>';
		}

		$output .= '</a>';
	}
}