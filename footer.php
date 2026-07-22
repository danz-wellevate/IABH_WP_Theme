<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>




</div> <!-- CLOSING DIV FOR MAIN CONTENT -->

<?php
// ACF Theme Options — Footer
$footer_logo      = get_field( 'footer_logo', 'option' );
$main_information = get_field( 'main_information', 'option' );
$main_address      = get_field( 'main_address', 'option' );
$footer_email      = get_field( 'email', 'option' );
$cta_link          = get_field( 'cta_link', 'option' );
?>

<footer class="footer-wrapper" id="contact-us">
	<div class="container">
		<div class="footer-top">
			<div class="footer-brand">
				<?php if ( $footer_logo ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" rel="home">
						<img src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="<?php echo esc_attr( $footer_logo['alt'] ); ?>">
					</a>
				<?php endif; ?>
			</div>

			<div class="footer-contact">
				<div class="footer-contact-heading">
					<span>Contact information</span>
				</div>

				<div class="footer-contact-columns">
					<?php if ( $main_information ) : ?>
						<div class="footer-contact-col"><?php echo nl2br(  $main_information ); ?></div>
					<?php endif; ?>

					<?php if ( $main_address ) : ?>
						<div class="footer-contact-col"><?php echo nl2br( $main_address ); ?></div>
					<?php endif; ?>

					<?php if ( $footer_email ) : ?>
						<div class="footer-contact-col">
							<a href="mailto:<?php echo esc_attr( $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ( $cta_link ) :
		$cta_url    = $cta_link['url'];
		$cta_title  = $cta_link['title'];
		$cta_target = ! empty( $cta_link['target'] ) ? $cta_link['target'] : '_self';
		?>
		<div class="footer-bottom">
			<div class="container">
				<a class="footer-legal-link" href="<?php echo esc_url( $cta_url ); ?>" target="<?php echo esc_attr( $cta_target ); ?>">
					<?php echo esc_html( $cta_title ); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>
</footer>

</div><!-- .site #page -->

<?php wp_footer(); ?>

</body>

</html>

