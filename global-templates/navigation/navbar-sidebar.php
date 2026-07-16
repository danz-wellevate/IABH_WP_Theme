<?php 
// Navbar Main Template
?>

<div class="inner-wrapper-navbar">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
		<?php 
		$brand_logo_svg = get_field('brand_logo_svg', 'option');

		if (!empty($brand_logo_svg)) {
			echo '<span class="navbar-logo-svg">' . $brand_logo_svg . '</span>';
		} elseif (has_custom_logo()) {
			echo '<span class="navbar-logo">';
			the_custom_logo();
			echo '</span>';
		} else {
			echo '<h1 class="navbar-title">' . esc_html(get_bloginfo('name')) . '</h1>';
		}
		?>
	</a>

	<?php
	wp_nav_menu( array(
	'theme_location'  => 'primary',
	'container'       => 'nav',
	'container_class' => 'navbar-main-menu',
	'menu_class'      => 'navbar-nav',
	'fallback_cb'     => false,
	'walker'          => new Primary_Menu_Walker(),
	) );
	?>


	<div class="cta-headers">
		<?php
		$pn = get_field('phone_number', 'option');

		if ( $pn ) :
		$url    = esc_url( $pn['url'] );
		$target = esc_attr( $pn['target'] ?: '_self' );
		?>
		<a class="cta-item" href="<?php echo $url; ?>" target="<?php echo $target; ?>" rel="noopener noreferrer">
			<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
				<path d="M11.4041 9.92279C10.914 9.43898 10.3022 9.43898 9.8153 9.92279C9.44385 10.2911 9.0724 10.6594 8.70719 11.034C8.6073 11.137 8.52302 11.1589 8.40129 11.0902C8.16094 10.9591 7.90498 10.853 7.67399 10.7094C6.5971 10.032 5.695 9.16118 4.89592 8.18108C4.49949 7.69414 4.14677 7.17288 3.90018 6.58606C3.85024 6.46745 3.8596 6.38942 3.95636 6.29266C4.32782 5.9337 4.6899 5.56538 5.05511 5.19706C5.5639 4.68516 5.5639 4.08586 5.05199 3.57083C4.76169 3.27743 4.4714 2.99026 4.18111 2.69685C3.88145 2.3972 3.58491 2.09443 3.28213 1.7979C2.79207 1.32033 2.18027 1.32033 1.69332 1.80102C1.31875 2.16934 0.959787 2.54703 0.578972 2.9091C0.22625 3.24309 0.048328 3.65199 0.0108708 4.12956C-0.0484365 4.90677 0.141971 5.64029 0.410414 6.35508C0.959787 7.83461 1.79633 9.1487 2.8108 10.3535C4.18111 11.9829 5.81674 13.272 7.73018 14.2022C8.59169 14.6204 9.48443 14.9419 10.4552 14.995C11.1232 15.0325 11.7038 14.8639 12.1689 14.3426C12.4872 13.9868 12.8462 13.6622 13.1833 13.322C13.6828 12.8163 13.6859 12.2045 13.1896 11.7051C12.5965 11.1089 12.0003 10.5159 11.4041 9.92279Z" fill="#24356D"/>
				<path d="M10.8079 7.43507L11.9597 7.23843C11.7787 6.18029 11.2792 5.22203 10.5207 4.46042C9.71853 3.65823 8.70407 3.15257 7.58659 2.9965L7.42428 4.15453C8.28892 4.27626 9.07552 4.66643 9.69668 5.28758C10.2835 5.87439 10.6674 6.61728 10.8079 7.43507Z" fill="#24356D"/>
				<path d="M12.609 2.42842C11.2793 1.09872 9.5968 0.259073 7.73954 0L7.57723 1.15802C9.18165 1.38276 10.6362 2.11004 11.7849 3.25558C12.8743 4.34493 13.5891 5.72145 13.8482 7.23531L15 7.03866C14.6972 5.28446 13.87 3.69257 12.609 2.42842Z" fill="#24356D"/>
			</svg>
		</a>
		<?php endif; ?>
		<?php
		$linkedin = get_field('linkedin_url', 'option');

		if ( $linkedin ) :
		$url    = esc_url( $linkedin['url'] );
		$target = esc_attr( $linkedin['target'] ?: '_self' );
		?>
		<a class="cta-item" href="<?php echo $url; ?>" target="<?php echo $target; ?>" rel="noopener noreferrer">
			<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
			<path d="M15 15V9.50625C15 6.80625 14.4187 4.74375 11.2687 4.74375C9.75 4.74375 8.7375 5.56875 8.325 6.35625H8.2875V4.9875H5.30625V15H8.41875V10.0312C8.41875 8.71875 8.6625 7.4625 10.275 7.4625C11.8688 7.4625 11.8875 8.94375 11.8875 10.1063V14.9813H15V15Z" fill="#24356D"/>
			<path d="M0.24375 4.9875H3.35625V15H0.24375V4.9875Z" fill="#24356D"/>
			<path d="M1.8 0C0.80625 0 0 0.80625 0 1.8C0 2.79375 0.80625 3.61875 1.8 3.61875C2.79375 3.61875 3.6 2.79375 3.6 1.8C3.6 0.80625 2.79375 0 1.8 0Z" fill="#24356D"/>
			</svg>
		</a>
		<?php endif; ?>
	</div>
</div>

<!-- SECONDARY SIDEBAR (POPULATED BY JS) -->
<div id="secondary-sidebar">
	<div class="secondary-menu-container"></div>
</div>
