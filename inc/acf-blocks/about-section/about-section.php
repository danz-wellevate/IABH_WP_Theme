<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__about-section';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$block_id = 'about-illustration-' . esc_attr( $block['id'] );

// ACF fields
$bgColor = get_field('about-section_background_color');
$header = get_field('header');
$paragraph = get_field('paragraph');
$image = get_field('image');
$objectives = get_field('objectives');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
     <div class="inner-container">
      <div class="col">
        <h2 class="header"><?= $header ?></h2>
      </div>
      <div class="col">
        <div class="content">
          <div class="paragraph">
            <?= $paragraph ?>
          </div>
          <div class="illustration">
            <?php if ($image) : ?>
              <div class="illustration-zoom-wrap" id="<?= $block_id ?>" data-illustration-zoom>
                <div class="illustration-zoom-controls" role="group" aria-label="<?php esc_attr_e( 'Zoom map', 'understrap' ); ?>">
                  <button type="button" class="illustration-zoom-btn" data-zoom-in aria-label="<?php esc_attr_e( 'Zoom in', 'understrap' ); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
                      <path d="M11 8V14M8 11H14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                      <path d="M16.5 16.5L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                  </button>
                  <button type="button" class="illustration-zoom-btn" data-zoom-out aria-label="<?php esc_attr_e( 'Zoom out', 'understrap' ); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
                      <path d="M8 11H14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                      <path d="M16.5 16.5L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                  </button>
                </div>
                <div class="illustration-zoom-viewport">
                  <img
                    src="<?= esc_url($image['url']) ?>"
                    alt="<?= esc_attr($image['alt']) ?>"
                    class="illustration-zoom-img"
                    data-zoom-img
                    draggable="false"
                  >
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="legends-repeater">
            <?php if (have_rows('objectives')) : ?>
              <?php while (have_rows('objectives')) : the_row(); ?>
                <?php
                $marker = get_sub_field('marker');
                $description = get_sub_field('description');
                ?>
                <div class="item">
                  <div class="marker">
                    <?php if ($marker) : ?>
                      <img src="<?= esc_url($marker['url']) ?>" alt="<?= esc_attr($marker['alt']) ?>">
                    <?php endif; ?>
                  </div>
                  <div class="description">
                    <?= esc_html($description) ?>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
     </div>
  </div>
</div>

<script>

(function () {
	var MIN_SCALE  = 1;
	var MAX_SCALE  = 3;
	var STEP       = 0.25;

	// Should match your $vp-tabletPortrait SCSS variable in px.
	// Adjust this if your breakpoint value differs.
	var MOBILE_BREAKPOINT = 768;

	function isCompact() {
		return window.innerWidth <= MOBILE_BREAKPOINT;
	}

	document.querySelectorAll('[data-illustration-zoom]').forEach(function (wrap) {
		var img        = wrap.querySelector('[data-zoom-img]');
		var zoomInBtn  = wrap.querySelector('[data-zoom-in]');
		var zoomOutBtn = wrap.querySelector('[data-zoom-out]');
		var viewport   = wrap.querySelector('.illustration-zoom-viewport');

		if (!img || !zoomInBtn || !zoomOutBtn || !viewport) return;

		var scale   = MIN_SCALE;
		var compact = isCompact();

		var baseWidth  = img.offsetWidth  || wrap.offsetWidth;
		var baseHeight = viewport.offsetHeight;
		viewport.style.height = baseHeight + 'px';

		function resetTransformState() {
			img.style.width     = '';
			img.style.height    = '';
			img.style.transform = '';
			viewport.scrollLeft = 0;
			viewport.scrollTop  = 0;
		}

		// ----- Desktop: resize the image, allow scroll-based panning -----
		function applyScaleDesktop() {
			var viewportWidth  = viewport.clientWidth;
			var viewportHeight = viewport.clientHeight;


			var oldScrollWidth  = viewport.scrollWidth;
			var oldScrollHeight = viewport.scrollHeight;
			var centerXRatio = oldScrollWidth  > 0 ? (viewport.scrollLeft + viewportWidth  / 2) / oldScrollWidth  : 0.5;
			var centerYRatio = oldScrollHeight > 0 ? (viewport.scrollTop  + viewportHeight / 2) / oldScrollHeight : 0.5;

			img.style.transform = '';
			img.style.width  = (baseWidth * scale) + 'px';
			img.style.height = 'auto';

			var newScrollWidth  = viewport.scrollWidth;
			var newScrollHeight = viewport.scrollHeight;

			viewport.scrollLeft = (centerXRatio * newScrollWidth)  - (viewportWidth  / 2);
			viewport.scrollTop  = (centerYRatio * newScrollHeight) - (viewportHeight / 2);
		}

		// ----- Mobile/Tablet: scale in place, no resize, no panning -----
		function applyScaleCompact() {
			img.style.width     = '100%';
			img.style.height    = 'auto';
			img.style.transform = 'scale(' + scale + ')';
			viewport.scrollLeft = 0;
			viewport.scrollTop  = 0;
		}

		function applyScale() {
			if (compact) {
				applyScaleCompact();
			} else {
				applyScaleDesktop();
			}

			zoomOutBtn.disabled = scale <= MIN_SCALE;
			zoomInBtn.disabled  = scale >= MAX_SCALE;
			wrap.classList.toggle('is-zoomed', scale > MIN_SCALE && !compact);
		}

		zoomInBtn.addEventListener('click', function () {
			scale = Math.min(MAX_SCALE, Math.round((scale + STEP) * 100) / 100);
			applyScale();
		});

		zoomOutBtn.addEventListener('click', function () {
			scale = Math.max(MIN_SCALE, Math.round((scale - STEP) * 100) / 100);
			applyScale();
		});

	
		var isDragging = false;
		var startX = 0, startY = 0, scrollLeftStart = 0, scrollTopStart = 0;

		viewport.addEventListener('mousedown', function (e) {
			if (compact || scale <= MIN_SCALE) return;
			isDragging = true;
			viewport.classList.add('is-dragging');
			startX = e.pageX;
			startY = e.pageY;
			scrollLeftStart = viewport.scrollLeft;
			scrollTopStart  = viewport.scrollTop;
		});

		window.addEventListener('mouseup', function () {
			isDragging = false;
			viewport.classList.remove('is-dragging');
		});

		window.addEventListener('mousemove', function (e) {
			if (!isDragging || compact) return;
			e.preventDefault();
			viewport.scrollLeft = scrollLeftStart - (e.pageX - startX);
			viewport.scrollTop  = scrollTopStart - (e.pageY - startY);
		});


		window.addEventListener('resize', function () {
			var nowCompact = isCompact();

			if (scale === MIN_SCALE) {
				viewport.style.height = 'auto';
				baseWidth  = wrap.offsetWidth;
				baseHeight = viewport.offsetHeight;
				viewport.style.height = baseHeight + 'px';
			}

			if (nowCompact !== compact) {
				compact = nowCompact;
				scale = MIN_SCALE;
				resetTransformState();
				applyScale();
			}
		});
	});
})();
</script>