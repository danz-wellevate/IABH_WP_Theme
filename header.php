<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
$navbar_type       = get_theme_mod( 'understrap_navbar_type', 'collapse' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<?php if ( !is_404() ) : ?>
<body <?php body_class(); ?> <?php understrap_body_attributes(); ?> data-barba="wrapper">
<?php do_action( 'wp_body_open' ); ?>

	<!-- ******************* The Navbar Area ******************* -->
	<header id="wrapper-navbar" class="main-header fixed-top" itemscope itemtype="http://schema.org/WPHeader">

		<a class="skip-link <?php echo understrap_get_screen_reader_class( true ); ?>" href="#content">
			<?php esc_html_e( 'Skip to content', 'understrap' ); ?>
		</a>

		
		<div class="top-navbar-overlay">
			<div class="container">
				<?php get_template_part( 'global-templates/navbar', 'main' ); ?>
			</div>
		</div>
		


	</header><!-- #wrapper-navbar -->

	<div class="site" id="page">

		<div class="sidebar-navbar-overlay">
			<?php get_template_part( 'global-templates/navigation/navbar', 'sidebar' ); ?>
		</div>

<?php endif; ?>



