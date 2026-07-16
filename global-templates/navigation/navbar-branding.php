<?php
/**
 * Navbar branding
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$siteLogoSVG = get_field('logo_svg', 'option');
if( !empty( $siteLogoSVG ) ): ?>
	<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
		<?= $siteLogoSVG ?>
	</a>
<?php else : ?>
	<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
		<?php bloginfo( 'name' ); ?>
	</a>
<?php endif; ?>