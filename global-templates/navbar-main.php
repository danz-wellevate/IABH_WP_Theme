<?php 
//Navbar Main Template 
// 
// ?>

<div class="inner-wrapper-navbar">


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

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
		<?php 
		// Check if the ACF field 'brand_logo_svg' has a value
		$brand_logo_svg = get_field('brand_logo_svg', 'option');
		if ( !empty($brand_logo_svg) ) {
			// Output the SVG code directly
			echo '<span class="navbar-logo-svg">' . $brand_logo_svg . '</span>';
		} elseif ( has_custom_logo() ) {
			// Display the custom logo wrapped in a div for styling
			echo '<span class="navbar-logo">';
			the_custom_logo();
			echo '</span>';
		} else {
			// Display the site name in an <h1> for branding
			echo '<h1 class="navbar-title">' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
		}
		?>
	</a>

	<div class="show-navigation">
		<button class="custom-btn" aria-label="Toggle Menu">
			<div class="dots">
				<span class="dot one"></span>
				<span class="dot two"></span>
				<span class="dot three"></span>
			</div>
		</button>
	</div>


</div>

<?php if ( have_rows('main_menu', 'option') ) : ?>
	<div class="sliding-menu-wrapper">
		<div class="sliding-menu-container">
			<!-- Main Menu -->
			<ul class="main-menu active" data-level="0"> 
				<?php 
				$menu_counter = 0; // Create a counter
				while ( have_rows('main_menu', 'option') ) : the_row();
					$menu_counter++; // Increment counter
					$main_link = get_sub_field('main_menu_item'); 
					$has_submenu = have_rows('sub_menu');
				?> 
					<li class="menu-item <?php echo $has_submenu ? 'has-submenu' : ''; ?>"> 
						<?php if ( $main_link ) : ?> 
							<?php if ( $has_submenu ) : ?>
								<a href="#" class="menu-trigger" aria-haspopup="true" aria-expanded="false" data-submenu="submenu-<?php echo $menu_counter; ?>">
									<?php echo esc_html($main_link['title']); ?> 
									<span class="arrow">
										<svg xmlns="http://www.w3.org/2000/svg" width="8" height="13" viewBox="0 0 8 13" fill="none">
										<path d="M-5.24338e-07 1.00456L-4.37843e-08 11.9983C-4.82062e-09 12.8897 1.07709 13.3354 1.7085 12.704L6.51826 7.89422C7.28894 7.12354 7.28894 5.87003 6.51826 5.09936L1.7085 0.28959C1.07709 -0.332522 -5.63301e-07 0.113171 -5.24338e-07 1.00456Z" fill="#24356D"/>
										</svg>
									</span>
								</a>
							<?php else : ?>
								<a href="<?php echo esc_url($main_link['url']); ?>" 
								target="<?php echo esc_attr($main_link['target'] ?: '_self'); ?>"> 
									<?php echo esc_html($main_link['title']); ?> 
								</a>
							<?php endif; ?>
						<?php endif; ?> 
					</li> 
				<?php endwhile; ?> 
			</ul>

			<!-- Submenus -->
			<?php 
			$submenu_counter = 0; // Create matching counter for submenus
			while ( have_rows('main_menu', 'option') ) : the_row();
				$submenu_counter++; // Increment to match main menu
				$main_link = get_sub_field('main_menu_item'); 
			?> 
				<?php if ( have_rows('sub_menu') ) : ?> 
					<ul class="sub-menu" id="submenu-<?php echo $submenu_counter; ?>" data-level="1"> 
						<li class="back-button-wrapper">
							<a href="#" class="back-button">
								<span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="13" viewBox="0 0 8 13" fill="none">
  <path d="M7.09998 12.0018L7.09998 1.00219C7.09998 0.110341 6.02232 -0.335586 5.39058 0.296143L0.578286 5.10846C-0.192796 5.87955 -0.192796 7.13371 0.578286 7.9048L5.39058 12.7171C6.02232 13.3395 7.09998 12.8936 7.09998 12.0018Z" fill="#00A4C3"/>
</svg></span> Zurück
							</a>
						</li>
						<?php while ( have_rows('sub_menu') ) : the_row();  
							$sub_link = get_sub_field('sub_menu_item'); 
						?> 
							<?php if ( $sub_link ) : ?> 
								<li> 
									<a href="<?php echo esc_url($sub_link['url']); ?>" 
									target="<?php echo esc_attr($sub_link['target'] ?: '_self'); ?>"> 
										<?php echo esc_html($sub_link['title']); ?> 
									</a> 
								</li> 
							<?php endif; ?> 
						<?php endwhile; ?> 
					</ul> 
				<?php endif; ?> 
			<?php endwhile; ?> 
		</div>
	</div>
<?php endif; ?>