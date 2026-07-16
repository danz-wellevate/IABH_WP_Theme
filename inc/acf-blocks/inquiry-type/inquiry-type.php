<?php
// Gutenberg Block Settings
$anchor_id = ! empty( $block['anchor'] ) ? 'id="' . esc_attr( $block['anchor'] ) . '"' : '';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__inquiry-type';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}

// ACF fields
$bg_color_block = get_field( 'inquiry-type_background_color' );
$inqHeader      = get_field( 'inq_header' );
$inqSubheader   = get_field( 'inq_subheader' );
?>

<div class="block--custom-layout <?= esc_attr( $class_name ); ?>" <?= $anchor_id; ?>
	style="background-color: <?= esc_attr( $bg_color_block ?: '#FFFFFF' ); ?>;">
	
	<div class="container">

		<div class="section-header-wrapper">
			<?php if ( $inqHeader ) : ?>
				<h2 class="section-header"><?= esc_html( $inqHeader ); ?></h2>
			<?php endif; ?>

			<?php if ( $inqSubheader ) : ?>
				<div class="body-text">
					<p><?= esc_html( $inqSubheader ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<!-- Block Content -->
		<div class="key-inquiry">
			<?php if ( have_rows( 'inquiry_type' ) ) : ?>
				<?php while ( have_rows( 'inquiry_type' ) ) : the_row(); 
					$svg_icon = get_sub_field( 'svg_icon' );
					$item_bg  = get_sub_field( 'background_color' );
					$header   = get_sub_field( 'header' );
				?>
					<div class="inquiry__item"
						style="background-color: <?= esc_attr( $item_bg ?: 'transparent' ); ?>;">

						<?php if ( $svg_icon ) : ?>
							<div class="svg_icon">
								<?= $svg_icon; ?>
							</div>
						<?php endif; ?>

						<?php if ( $header ) : ?>
							<h3><?= $header ?></h3>
						<?php endif; ?>

					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>

		<div class="inquiry__cta">
			

			<button type="button" class="btn btn--transparent" id="cf-popup-trigger">
				Nachricht senden
			</button>
		</div>

	</div>

</div>


<div class="cf-popup" aria-hidden="true">
  <div class="cf-popup__overlay"></div>

  <div class="cf-popup__content">


      <div class="header-section">
        <?php $form_header = get_field( 'form_header' ); ?>
        <?php if ( $form_header ) : ?>
          <h2><?= esc_html( $form_header ); ?></h2>
        <?php endif; ?>

        <div class="logo">
          <img
            src="/wp-content/uploads/2026/01/wno-official-color-pallette.webp"
            alt="WNO Logo"
          />
        </div>
      </div>

      <?php $form_subheader = get_field( 'forn_subheader' ); ?>
      <?php if ( $form_subheader ) : ?>
        <div class="subheader body-text">
          <p><?= esc_html( $form_subheader ); ?></p>
        </div>
      <?php endif; ?>

      <?php
        $form_shortcode = get_field( 'form_shortcode' );
        if ( $form_shortcode ) {
          echo do_shortcode( $form_shortcode );
        }
      ?>


    <button
      type="button"
      class="cf-popup__close"
      aria-label="Close modal"
    >
      Zurück zur Seite
    </button>

  </div><!-- /.cf-popup__content -->
</div><!-- /.cf-popup -->
