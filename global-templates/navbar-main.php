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

<script>
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('[data-navigator-dropdown]').forEach(function (wrap) {
		var toggle      = wrap.querySelector('[data-navigator-toggle]');
		var menu        = wrap.querySelector('[data-navigator-menu]');
		var labelEl     = toggle ? toggle.querySelector('.navigator-toggle-label') : null;
		var defaultLabel = labelEl ? (labelEl.getAttribute('data-navigator-default-label') || labelEl.textContent) : '';

		if (!toggle || !menu || !labelEl) return;

		function closeMenu() {
			wrap.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
		}

		function openMenu() {
			wrap.classList.add('is-open');
			toggle.setAttribute('aria-expanded', 'true');
		}

		function setLabel(text) {
			labelEl.textContent = text;
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

		// ---- Build a map of sectionId -> { link, label, el } for every in-page anchor link ----
		var sectionLinks = []; // ordered list, keeps document order for scroll-spy fallback logic

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

			var targetEl = document.getElementById(targetId);
			if (!targetEl) return; // no matching section on this page, let it navigate normally

			sectionLinks.push({
				id:    targetId,
				link:  link,
				label: (link.textContent || '').trim(),
				el:    targetEl
			});

			link.addEventListener('click', function (e) {
				e.preventDefault();

				var header       = document.getElementById('wrapper-navbar');
				var headerHeight = header ? header.offsetHeight : 0;
				var extraGap     = 20; // breathing room below the header
				var targetTop    = targetEl.getBoundingClientRect().top + window.pageYOffset - headerHeight - extraGap;

				window.scrollTo({ top: targetTop, behavior: 'smooth' });

				// Update the label immediately so it doesn't wait on the scroll-spy.
				setLabel((link.textContent || '').trim());
				wrap.setAttribute('data-navigator-active', targetId);

				closeMenu();
				history.pushState(null, '', '#' + targetId);
			});
		});

		// ---- Scroll-spy: highlight/label whichever section is currently in view ----
		if (sectionLinks.length && 'IntersectionObserver' in window) {

			var header       = document.getElementById('wrapper-navbar');
			var headerHeight = header ? header.offsetHeight : 0;

			// A thin horizontal band just below the sticky header — the section
			// crossing this line is considered "active".
			var topMargin    = -(headerHeight + 10);
			var bottomMargin = -(Math.max(window.innerHeight - headerHeight - 10 - 150, 0));

			var currentActiveId = null;

			// Named so the resize handler below can rebuild the observer with
			// the same logic — IntersectionObserver instances don't expose
			// their callback (there's no such thing as observer.callback), so
			// relying on that to reuse it silently created a no-op observer
			// after every resize and killed the scroll-spy from then on.
			function handleSectionIntersections(entries) {
				entries.forEach(function (entry) {
					var match = sectionLinks.find(function (s) { return s.el === entry.target; });
					if (!match) return;

					if (entry.isIntersecting) {
						currentActiveId = match.id;
						setLabel(match.label);
						wrap.setAttribute('data-navigator-active', match.id);

						sectionLinks.forEach(function (s) {
							s.link.classList.toggle('is-active', s.id === match.id);
						});
					}
				});

				// If nothing is intersecting (e.g. above the very first section),
				// fall back to the default label.
				var anyIntersecting = sectionLinks.some(function (s) {
					return s.el.getBoundingClientRect().top < (headerHeight + 10) &&
						   s.el.getBoundingClientRect().bottom > (headerHeight + 10);
				});
				if (!anyIntersecting && window.scrollY < 100) {
					currentActiveId = null;
					setLabel(defaultLabel);
					wrap.removeAttribute('data-navigator-active');
					sectionLinks.forEach(function (s) { s.link.classList.remove('is-active'); });
				}
			}

			var observer = new IntersectionObserver(handleSectionIntersections, {
				root: null,
				rootMargin: topMargin + 'px 0px ' + bottomMargin + 'px 0px',
				threshold: 0
			});

			sectionLinks.forEach(function (s) { observer.observe(s.el); });

			// Recompute margins on resize (header height / viewport can change).
			window.addEventListener('resize', function () {
				headerHeight = header ? header.offsetHeight : 0;
				topMargin    = -(headerHeight + 10);
				bottomMargin = -(Math.max(window.innerHeight - headerHeight - 10 - 150, 0));
				observer.disconnect();
				observer = new IntersectionObserver(handleSectionIntersections, {
					root: null,
					rootMargin: topMargin + 'px 0px ' + bottomMargin + 'px 0px',
					threshold: 0
				});
				sectionLinks.forEach(function (s) { observer.observe(s.el); });
			});

			// If the page loads with a hash already in the URL, set the label immediately.
			if (window.location.hash) {
				var initialId = window.location.hash.slice(1);
				var initialMatch = sectionLinks.find(function (s) { return s.id === initialId; });
				if (initialMatch) {
					setLabel(initialMatch.label);
					wrap.setAttribute('data-navigator-active', initialMatch.id);
				}
			}
		}
	});
});
</script>