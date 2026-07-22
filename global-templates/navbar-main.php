<?php

?>

<div class="inner-wrapper-navbar">

	<?php


	$brand_logo_svg = get_field( 'brand_logo_svg', 'option' );
	$iabh_email     = get_field( 'email', 'option' );

	if ( ! empty( $brand_logo_svg ) ) :
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
			<span class="navbar-logo-svg"><?php echo $brand_logo_svg; ?></span>
		</a>
		<?php
	elseif ( has_custom_logo() ) :
		?>
		<div class="navbar-brand">
			<span class="navbar-logo">
				<?php the_custom_logo(); ?>
			</span>
		</div>
		<?php
	else :
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
			<h1 class="navbar-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
		</a>
		<?php
	endif;
	?>

	<div class="site-header-actions">

		<!-- Navigator Dropdown (self-contained, no Bootstrap JS dependency) -->
		<div class="navigator-dropdown" data-navigator-dropdown>
			<button
				class="navigator-toggle"
				type="button"
				id="navigatorDropdown"
				aria-haspopup="true"
				aria-expanded="false"
				data-navigator-toggle
			>
				<span class="navigator-toggle-label" data-navigator-default-label="<?php esc_attr_e( 'Introduction', 'understrap' ); ?>"><?php esc_html_e( 'Introduction', 'understrap' ); ?></span>
				<svg class="navigator-caret" width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">
					<path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

			<div class="navigator-menu-wrap" aria-labelledby="navigatorDropdown" data-navigator-menu>
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'navigator-menu list-unstyled mb-0',
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
				} else {
					?>
					<p class="navigator-empty">
						<?php esc_html_e( 'No menu assigned to the "Primary" location yet.', 'understrap' ); ?>
					</p>
					<?php
				}
				?>
			</div>
		</div>

		<!-- Email Button -->
		<a
			href="mailto:<?php echo esc_attr( $iabh_email ); ?>"
			class="call-btn"
			aria-label="<?php echo esc_attr( sprintf( __( 'Email us at %s', 'understrap' ), $iabh_email ) ); ?>"
			title="<?php echo esc_attr( $iabh_email ); ?>"
		>
			<svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
  <path d="M20.6001 3.6001L11.6091 9.3271C11.304 9.50431 10.9574 9.59765 10.6046 9.59765C10.2518 9.59765 9.9052 9.50431 9.6001 9.3271L0.600098 3.6001M2.6001 0.600098H18.6001C19.7047 0.600098 20.6001 1.49553 20.6001 2.6001V14.6001C20.6001 15.7047 19.7047 16.6001 18.6001 16.6001H2.6001C1.49553 16.6001 0.600098 15.7047 0.600098 14.6001V2.6001C0.600098 1.49553 1.49553 0.600098 2.6001 0.600098Z" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
		</a>

	</div>

</div>

