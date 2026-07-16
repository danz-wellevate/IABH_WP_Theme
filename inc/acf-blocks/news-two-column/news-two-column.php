<?php
// --------------------------------------------------
// Gutenberg Block Settings
// --------------------------------------------------
$anchor_id = ! empty( $block['anchor'] )
  ? 'id="' . esc_attr( $block['anchor'] ) . '"'
  : '';

$class_name = 'block--custom-layout__news-two-column';
if ( ! empty( $block['className'] ) ) {
  $class_name .= ' ' . esc_attr( $block['className'] );
}

// --------------------------------------------------
// ACF Fields (block-level)
// --------------------------------------------------
$section_bg = get_field( 'news-two-column_background_color' );
$header     = get_field( 'header' );
?>

<div
  class="block--custom-layout <?php echo $class_name; ?>"
  <?php echo $anchor_id; ?>
  <?php if ( $section_bg ) : ?>
    style="background-color: <?php echo esc_attr( $section_bg ); ?>;"
  <?php endif; ?>
>
  <div class="container">

    <?php if ( $header ) : ?>
      <div class="section-header-wrapper">
        <h2 class="section-header"><?php echo esc_html( $header ); ?></h2>
      </div>
    <?php endif; ?>

    <?php if ( have_rows( 'announcements' ) ) : ?>
      <div class="news-two-column-wrapper">

        <?php while ( have_rows( 'announcements' ) ) : the_row();

          // ------------------------------------------
          // Repeater fields
          // ------------------------------------------
          $date        = get_sub_field( 'date' );
          $title       = get_sub_field( 'title' );
          $description = get_sub_field( 'description' );
          $file        = get_sub_field( 'downloadable_file' );
          $card_bg     = get_sub_field( 'background_color' ) ?: '#EDEDEE';
          $btn_bg      = get_sub_field( 'button_background_color' ) ?: '#0099AA'; // $pacific-blue
          $btn_text    = get_sub_field( 'button_text_color' ) ?: '#FFFFFF';
          $btn_style   = get_sub_field( 'button_style' );

          // ------------------------------------------
          // Inline styles (row-scoped)
          // ------------------------------------------
          $card_style = 'style="background-color:' . esc_attr( $card_bg ) . ';"';

          $btn_style_attr = 'style="background-color:' . esc_attr( $btn_bg ) . '; color:' . esc_attr( $btn_text ) . ';"';

        ?>

          <div class="col">
            <div class="column-inner" <?php echo $card_style; ?>>

              <?php if ( $date ) : ?>
                <div class="date" style="color: <?php echo esc_attr( $card_bg ); ?>"><?php echo esc_html( $date ); ?></div>
              <?php endif; ?>

              <?php if ( $title ) : ?>
                <h3 class="inner-title"><?php echo $title ?></h3>
              <?php endif; ?>

              <?php if ( $description ) : ?>
                <div class="description body-text">
                  <?php echo wp_kses_post( $description ); ?>
                </div>
              <?php endif; ?>

              <?php if ( $file && ! empty( $file['url'] ) ) : ?>
                <a
                  href="<?php echo esc_url( $file['url'] ); ?>"
                  class="btn btn--rounded btn--<?php echo esc_attr( $btn_style['value'] ?? 'outline' ); ?>"
                  target="_blank"
                  <?php echo $btn_style_attr; ?>
                >
                  <?php echo esc_html( $file['title'] ); ?>
                </a>
              <?php endif; ?>

            </div>
          </div>

        <?php endwhile; ?>

      </div>
    <?php endif; ?>

  </div>
</div>