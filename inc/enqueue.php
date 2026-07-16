<?php
/**
 * Understrap enqueue scripts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'understrap_scripts' ) ) {

	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function understrap_scripts() {

		// Asset versions based on file modification time.
		$css_version = file_exists(
			get_stylesheet_directory() . '/assets/css/style.min.css'
		)
			? filemtime( get_stylesheet_directory() . '/assets/css/style.min.css' )
			: time();

		$js_version = file_exists(
			get_stylesheet_directory() . '/dist/main.bundle.js'
		)
			? filemtime( get_stylesheet_directory() . '/dist/main.bundle.js' )
			: time();

		/**
		 * Styles
		 */
		wp_enqueue_style(
			'fa-css',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
			[],
			null
		);

		wp_enqueue_style(
			'swiper-css',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			[],
			'11.2.10'
		);

		wp_enqueue_style(
			'understrap-custom-styles',
			get_stylesheet_directory_uri() . '/assets/css/style.min.css',
			[],
			$css_version
		);

		/**
		 * Scripts
		 */

		// ── Vendor scripts ────────────────────────────────────────────────
		wp_enqueue_script(
			'gsap',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
			[],
			null,
			true
		);

		wp_enqueue_script(
			'scrolltoplugin',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.7/ScrollToPlugin.min.js',
			[ 'gsap' ],
			null,
			true
		);

		wp_enqueue_script(
			'scrolltrigger',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js',
			[ 'gsap' ],
			null,
			true
		);

		wp_enqueue_script(
			'scrollsmoother',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollSmoother.min.js',
			[ 'gsap' ],
			null,
			true
		);

		wp_enqueue_script(
			'swiper-script',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			[],
			'11.2.10',
			true
		);

		// NTC Swiper init script — depends on swiper
		wp_enqueue_script(
			'ntc-swiper',
			get_stylesheet_directory_uri() . '/assets/js/ntc-swiper.js',
			[ 'swiper-script' ],
			$js_version,
			true
		);

		/**
		 * Main bundle
		 */
		wp_enqueue_script(
			'understrap-main-init',
			get_stylesheet_directory_uri() . '/dist/main.bundle.js',
			[
				'gsap',
				'scrolltrigger',
				'scrolltoplugin',
				'scrollsmoother',
				'swiper-script',
			],
			$js_version,
			true
		);

		// ── Footer nav submenu accordion toggle ───────────────────────────
		// Depends on understrap-main-init so it runs after Barba is set up.
		wp_enqueue_script(
			'footer-nav',
			get_stylesheet_directory_uri() . '/assets/js/footer-nav.js',
			[ 'understrap-main-init' ],
			$js_version,
			true
		);

		/**
		 * Fonts
		 * Note: WOFF2 files should NOT be enqueued as stylesheets.
		 * Use @font-face in CSS instead.
		 */

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );

add_filter(
	'script_loader_tag',
	function ( $tag, $handle, $src ) {

		// These get defer — intentionally excludes 'swiper-script', 'ntc-swiper', and 'footer-nav'
		// so they execute in order without defer potentially breaking sequencing.
		$defer_scripts = [
			'gsap',
			'scrolltoplugin',
			'scrolltrigger',
			'scrollsmoother',
			'understrap-main-init',
		];

		if ( in_array( $handle, $defer_scripts, true ) ) {
			return '<script src="' . esc_url( $src ) . '" defer></script>';
		}

		return $tag;
	},
	10,
	3
);