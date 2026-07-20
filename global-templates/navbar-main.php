<?php 
//Navbar Main Template 
// 
// ?>

<div class="inner-wrapper-navbar">




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



</div>

