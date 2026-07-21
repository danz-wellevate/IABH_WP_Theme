<?php

?>

<div class="inner-wrapper-navbar">

	<?php


	$brand_logo_svg = get_field( 'brand_logo_svg', 'option' );

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
				<span class="navigator-toggle-label"><?php esc_html_e( 'Introduction', 'understrap' ); ?></span>
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

		<!-- Call Button -->
		<a
			href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $iabh_phone_number ) ); ?>"
			class="call-btn"
			aria-label="<?php echo esc_attr( sprintf( __( 'Call us at %s', 'understrap' ), $iabh_phone_display ) ); ?>"
			title="<?php echo esc_attr( $iabh_phone_display ); ?>"
		>
			<svg class="call-btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
	<path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z"
		stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
		</a>

	</div>

</div>

<script>
// Self-contained dropdown toggle — does not depend on Bootstrap JS/Popper.
(function () {
	document.querySelectorAll('[data-navigator-dropdown]').forEach(function (wrap) {
		var toggle = wrap.querySelector('[data-navigator-toggle]');
		var menu   = wrap.querySelector('[data-navigator-menu]');

		if (!toggle || !menu) return;

		function closeMenu() {
			wrap.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
		}

		function openMenu() {
			wrap.classList.add('is-open');
			toggle.setAttribute('aria-expanded', 'true');
		}

		toggle.addEventListener('click', function (e) {
			e.stopPropagation();
			wrap.classList.contains('is-open') ? closeMenu() : openMenu();
		});

		document.addEventListener('click', function (e) {
			if (!wrap.contains(e.target)) closeMenu();
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closeMenu();
		});


		menu.querySelectorAll('a').forEach(function (link) {
			var href = link.getAttribute('href') || '';
			var hashIndex = href.indexOf('#');

			if (hashIndex === -1) return; // normal link to another page, leave alone

			var targetId   = href.slice(hashIndex + 1);
			var pathBefore = href.slice(0, hashIndex);
			var isSamePage = pathBefore === '' ||
				pathBefore === window.location.pathname ||
				pathBefore === window.location.href.split('#')[0];

			if (!targetId || !isSamePage) return;

			link.addEventListener('click', function (e) {
				var target = document.getElementById(targetId);
				if (!target) return; // no matching section on this page, let it navigate normally

				e.preventDefault();

				var header       = document.getElementById('wrapper-navbar');
				var headerHeight = header ? header.offsetHeight : 0;
				var extraGap     = 20; // breathing room below the header
				var targetTop    = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - extraGap;

				window.scrollTo({ top: targetTop, behavior: 'smooth' });

				closeMenu();
				history.pushState(null, '', '#' + targetId);
			});
		});
	});
})();
</script>