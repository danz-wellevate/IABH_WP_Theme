<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}


function my_theme_breadcrumbs() {
    $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
    $items = [];

    foreach ($ancestors as $ancestor_id) {
        $items[] = [
            'label' => get_the_title($ancestor_id),
            'url'   => get_permalink($ancestor_id),
        ];
    }

    // Add current page (no link)
    $items[] = [
        'label' => get_the_title(),
        'url'   => null,
    ];

    return $items;
}


/**
 * Global Kontakt Popup
 * Injects the same cf-popup used in the kontakt-overview block globally.
 * Intercepts /kontakt/ links EXCEPT those inside the navbar/navigation.
 * Skipped entirely on the /kontakt/ page itself.
 */
function enqueue_global_kontakt_popup() {
    // Don't load on the kontakt page — it already has the popup via the block
    if ( is_page('kontakt') ) return;

    // Get the kontakt page and pull ACF fields from it
    $kontakt_page = get_page_by_path('kontakt');
    if ( ! $kontakt_page ) return;

    $kontakt_id     = $kontakt_page->ID;
    $form_header    = get_field('form_header', $kontakt_id) ?: 'Kontaktformular';
    $form_subheader = get_field('form_subheader', $kontakt_id)
        ?: 'Haben Sie Fragen oder wünschen Sie weitere Informationen? Zögern Sie nicht, uns über untenstehendes Formular zu kontaktieren. Wir werden Ihre Anfrage anschliessend so schnell wie möglich bearbeiten und uns mit Ihnen in Verbindung setzen.';
    $form_shortcode = get_field('form_shortcode', $kontakt_id) ?: '[forminator_form id="668"]';
    ?>

    <div class="cf-popup" aria-hidden="true" id="global-cf-popup">
        <div class="cf-popup__overlay"></div>
        <div class="cf-popup__content">
            <div class="header-section">
                <?php if ( $form_header ) : ?>
                    <h2><?= esc_html( $form_header ); ?></h2>
                <?php endif; ?>
                <div class="logo">
                    <img src="/wp-content/uploads/2026/01/wno-official-color-pallette.webp" alt="WNO Logo" />
                </div>
            </div>

            <?php if ( $form_subheader ) : ?>
                <div class="subheader body-text">
                    <p><?= esc_html( $form_subheader ); ?></p>
                </div>
            <?php endif; ?>

            <?php echo do_shortcode( $form_shortcode ); ?>

            <button type="button" class="cf-popup__close" id="global-cf-popup-close" aria-label="Close modal">
                Zurück zur Seite
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const popup    = document.getElementById('global-cf-popup');
            const overlay  = popup.querySelector('.cf-popup__overlay');
            const closeBtn = document.getElementById('global-cf-popup-close');
            let form668Active = false;

            // Always reset popup to closed state on page load
            function resetPopup() {
                popup.setAttribute('aria-hidden', 'true');
                popup.style.visibility = 'hidden';
                popup.style.pointerEvents = 'none';
                overlay.style.opacity = '0';
                document.body.style.overflow = '';
            }

            function openPopup(e) {
                e.preventDefault();
                popup.setAttribute('aria-hidden', 'false');
                popup.style.visibility = 'visible';
                popup.style.pointerEvents = 'auto';
                overlay.style.opacity = '1';
                document.body.style.overflow = 'hidden';
            }

            function closePopup() {
                resetPopup();
            }

            // Reset on page load
            resetPopup();

            // Intercept /kontakt/ links EXCEPT those inside the navbar or navigation
            document.querySelectorAll('a[href*="/kontakt/"], a[href*="/kontakt"]').forEach(function (link) {
                if ( link.closest(
                    '#wrapper-navbar, nav, .navbar, .nav, .menu, .navigation, ' +
                    '.cta-headers, .cta-item, .inner-wrapper-navbar, header'
                ) ) return;

                link.addEventListener('click', openPopup);
            });

            // Close on close button
            closeBtn.addEventListener('click', closePopup);

            // Close on overlay click
            overlay.addEventListener('click', closePopup);

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closePopup();
            });

            // Track when form 668 is being submitted
            const form668 = document.getElementById('forminator-module-668');
            if ( form668 ) {
                form668.addEventListener('submit', function () {
                    form668Active = true;
                    // Reset flag after a few seconds
                    setTimeout(function () { form668Active = false; }, 5000);
                }, true);
            }

            // MutationObserver: watch the entire body for Forminator's toast
            // and remove it immediately if form 668 was the one submitted
            const toastObserver = new MutationObserver(function (mutations) {
                if ( !form668Active ) return;

                mutations.forEach(function (mutation) {
                    mutation.addedNodes.forEach(function (node) {
                        if ( node.nodeType !== 1 ) return;

                        // Forminator's native toast sits outside #forminator-module-668
                        // It uses classes like .forminator-notices, .forminator-toast
                        // or it may be a div appended directly to body/wrapper
                        const isToast = (
                            node.classList.contains('forminator-notices')   ||
                            node.classList.contains('forminator-toast')     ||
                            node.classList.contains('forminator-success')   ||
                            node.querySelector('.forminator-notices')       ||
                            node.querySelector('.forminator-toast')
                        );

                        const isInsideForm668 = node.closest && node.closest('#forminator-module-668');

                        if ( isToast && !isInsideForm668 ) {
                            node.style.display = 'none';
                            node.remove();
                        }
                    });
                });
            });

            toastObserver.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'enqueue_global_kontakt_popup');