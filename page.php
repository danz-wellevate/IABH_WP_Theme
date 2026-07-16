<?php
/**
 * The template for displaying all pages
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;

get_header();
$namespace = get_post_field( 'post_name', get_queried_object_id() );
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="main-content">

<style>
/* ── Sub-menu indentation — all resolutions ──────────────────────────
   This MUST live here in plain CSS, not in SCSS, because
   .footer-wrapper applies  ul, li, a { all: unset }  which strips
   all padding from every <a>, and the SCSS shorthand
   padding: 5px 0 !important  then resets padding-left back to 0.
   Four longhand properties + a longer selector chain beats it.
─────────────────────────────────────────────────────────────────── */
.footer-nav-wrapper .footer-nav-list > li .sub-menu li a,
.col--nav .footer-nav-list > li .sub-menu li a {
    padding-top:    5px  !important;
    padding-right:  0    !important;
    padding-bottom: 5px  !important;
    padding-left:   16px !important;
    cursor: pointer !important;
}

/* ── Forminator newsletter button — base ─────────────────────────── */
#forminator-module-510 .forminator-button,
#forminator-module-510 .forminator-button-submit,
#forminator-module-510 button.forminator-button,
#forminator-module-510 button.forminator-button-submit,
.newsletter-form .forminator-button,
.newsletter-form .forminator-button-submit {
    padding: 13px 26px !important;
    background: #1AAFBF !important;
    background-color: #1AAFBF !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 0 25px 25px 0 !important;
    cursor: pointer !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    white-space: nowrap !important;
    letter-spacing: 0.02em !important;
    flex-shrink: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important;
    width: auto !important;
    height: auto !important;
    line-height: 1.4 !important;
    box-shadow: none !important;
    text-transform: none !important;
    transition: background-color 0.25s ease, background 0.25s ease !important;
    -webkit-appearance: none !important;
    appearance: none !important;
}

#forminator-module-510 .forminator-button:hover,
#forminator-module-510 .forminator-button-submit:hover,
#forminator-module-510 button.forminator-button:hover,
#forminator-module-510 button.forminator-button-submit:hover,
.newsletter-form .forminator-button:hover,
.newsletter-form .forminator-button-submit:hover,
.footer-newsletter .forminator-button:hover,
.footer-newsletter .forminator-button-submit:hover,
.footer-wrapper .forminator-button:hover,
.footer-wrapper .forminator-button-submit:hover,
button.forminator-button.forminator-button-submit:hover {
    background: #EB574F !important;
    background-color: #EB574F !important;
    color: #ffffff !important;
}

/* ── Newsletter success popup ─────────────────────────────────────── */
#newsletter-success-popup {
    position: fixed;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%) translateY(30px);
    z-index: 99999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}
#newsletter-success-popup.is-visible {
    opacity: 1;
    pointer-events: auto;
    transform: translateX(-50%) translateY(0);
}
.nsp-inner {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #ffffff;
    color: #1a2e5a;
    border-radius: 16px;
    padding: 16px 22px 16px 18px;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.18), 0 2px 8px rgba(0, 0, 0, 0.08);
    min-width: 280px;
    max-width: 420px;
    font-family: inherit;
}
.nsp-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: #1AAFBF;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.nsp-icon svg {
    width: 20px;
    height: 20px;
    fill: none;
    stroke: #ffffff;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.nsp-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.nsp-title {
    font-size: 15px;
    font-weight: 700;
    color: #1a2e5a;
    line-height: 1.3;
}
.nsp-subtitle {
    font-size: 13px;
    font-weight: 400;
    color: rgba(26, 46, 90, 0.6);
    line-height: 1.4;
}
.nsp-close {
    flex-shrink: 0;
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    color: rgba(26, 46, 90, 0.35);
    line-height: 0;
    border-radius: 6px;
    transition: color 0.2s ease, background 0.2s ease;
}
.nsp-close:hover {
    color: #1a2e5a;
    background: rgba(26, 46, 90, 0.06);
}
.nsp-close svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    stroke-width: 2;
    stroke-linecap: round;
}
.nsp-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background: rgba(26, 174, 191, 0.15);
    border-radius: 0 0 16px 16px;
    overflow: hidden;
}
.nsp-progress-bar {
    height: 100%;
    width: 100%;
    background: #1AAFBF;
    transform-origin: left center;
    transform: scaleX(1);
    transition: transform linear;
}
.nsp-inner {
    position: relative;
}
@media (max-width: 480px) {
    #newsletter-success-popup {
        bottom: 20px;
        left: 16px;
        right: 16px;
        transform: translateY(30px);
    }
    #newsletter-success-popup.is-visible {
        transform: translateY(0);
    }
    .nsp-inner {
        min-width: unset;
        max-width: 100%;
    }
}
</style>

<!-- ── Success popup markup ──────────────────────────────────────── -->
<div id="newsletter-success-popup" role="status" aria-live="polite" aria-atomic="true">
    <div class="nsp-inner">
        <div class="nsp-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="nsp-text">
            <span class="nsp-title">Erfolgreich angemeldet!</span>
            <span class="nsp-subtitle">Danke – Sie erhalten unseren Newsletter.</span>
        </div>
        <button class="nsp-close" aria-label="Schließen">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="nsp-progress">
            <div class="nsp-progress-bar" id="nsp-bar"></div>
        </div>
    </div>
</div>

<div id="smooth-wrapper" data-barba="container" data-barba-namespace="<?php echo esc_attr( $namespace ); ?>">
    <div id="smooth-content">
        <div class="wrapper" id="page-wrapper">

            <?php
            while ( have_posts() ) {
                the_post();
                get_template_part( 'loop-templates/content', 'page' );
            }
            ?>

            <div class="footer-wrapper">
                <div class="container">
                    <div class="inner-container">

                        <!-- Newsletter Bar -->
                        <div class="footer-newsletter">
                            <p class="newsletter-label">Newsletter abonnieren</p>
                            <div class="newsletter-form">
                                <?php echo do_shortcode('[forminator_form id="510"]'); ?>
                            </div>
                        </div>

                        <div class="footer-divider"></div>

                        <!-- 3-Column Footer -->
                        <div class="inner-row footer-column">

                            <!-- Col 1: Brand + Contact + Socials -->
                            <div class="col col--brand">

                                <?php
                                $footer_logo = get_field( 'footer_logo', 'option' );
                                if ( ! empty( $footer_logo ) ) {
                                    echo '<div class="footer-logo">' . $footer_logo . '</div>';
                                }

                                $footer_contact = get_field( 'footer_contact_details', 'option' );
                                if ( ! empty( $footer_contact ) ) {
                                    echo '<div class="contact-information">' . $footer_contact . '</div>';
                                }
                                ?>

                                <div class="footer-socials">
                                    <?php
                                    $footer_socials = get_field( 'footer_social_links', 'option' );
                                    if ( ! empty( $footer_socials ) ) :
                                        foreach ( $footer_socials as $social ) : ?>
                                            <a href="<?php echo esc_url( $social['url'] ); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
                                                <?php if ( ! empty( $social['icon'] ) ) : ?>
                                                    <span class="social-icon"><?php echo $social['icon']; ?></span>
                                                <?php endif; ?>
                                                <?php if ( ! empty( $social['label'] ) ) : ?>
                                                    <span class="social-label"><?php echo esc_html( $social['label'] ); ?></span>
                                                <?php endif; ?>
                                            </a>
                                        <?php endforeach;
                                    else : ?>
                                        <a href="https://ch.linkedin.com/company/w%C3%A4rme-netz-ostschweiz" class="social-link" target="_blank" rel="noopener noreferrer">
                                            <span class="social-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                            </span>
                                            <span class="social-label">LinkedIn</span>
                                        </a>
                                        <a href="mailto:info@wno.ch" class="social-link" rel="noopener noreferrer">
                                            <span class="social-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                            </span>
                                            <span class="social-label">Email</span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                            </div><!-- .col--brand -->

                            <!-- Col 2: Left nav (desktop only) + copyright -->
                            <div class="col col--nav">
                                <?php
                                wp_nav_menu([
                                    'theme_location' => 'footer-left',
                                    'container'      => false,
                                    'menu_class'     => 'footer-nav-list',
                                    'fallback_cb'    => false,
                                ]);

                                $footer_copyright = get_field( 'footer_copyright', 'option' );
                                if ( ! empty( $footer_copyright ) ) {
                                    echo '<p class="footer-copyright">' . $footer_copyright . '</p>';
                                }

                                $terms_link = get_field( 'terms_and_conditions', 'option' );
                                if ( ! empty( $terms_link ) ) {
                                    echo '<a class="footer-legal-link" href="' . esc_url( $terms_link['url'] ) . '">' . esc_html( $terms_link['title'] ) . '</a>';
                                }
                                ?>
                            </div>

                            <!-- Col 3: Right nav (desktop only) -->
                            <div class="col col--nav">
                                <?php
                                wp_nav_menu([
                                    'theme_location' => 'footer-right',
                                    'container'      => false,
                                    'menu_class'     => 'footer-nav-list',
                                    'fallback_cb'    => false,
                                ]);
                                ?>
                            </div>

                            <!-- Tablet Nav Wrapper: both navs merged + copyright at bottom -->
                            <div class="footer-nav-wrapper">
                                <?php
                                wp_nav_menu([
                                    'theme_location' => 'footer-left',
                                    'container'      => false,
                                    'menu_class'     => 'footer-nav-list',
                                    'fallback_cb'    => false,
                                ]);

                                wp_nav_menu([
                                    'theme_location' => 'footer-right',
                                    'container'      => false,
                                    'menu_class'     => 'footer-nav-list',
                                    'fallback_cb'    => false,
                                ]);

                                $footer_copyright = get_field( 'footer_copyright', 'option' );
                                if ( ! empty( $footer_copyright ) ) {
                                    echo '<p class="footer-copyright">' . $footer_copyright . '</p>';
                                }

                                $terms_link = get_field( 'terms_and_conditions', 'option' );
                                if ( ! empty( $terms_link ) ) {
                                    echo '<a class="footer-legal-link" href="' . esc_url( $terms_link['url'] ) . '">' . esc_html( $terms_link['title'] ) . '</a>';
                                }
                                ?>
                            </div><!-- .footer-nav-wrapper -->

                        </div><!-- .footer-column -->

                    </div><!-- .inner-container -->
                </div><!-- .container -->
            </div><!-- .footer-wrapper -->

        </div><!-- #page-wrapper -->
    </div>
</div>

<!-- ── FAZ cookie banner: fix Datenschutzerklärung link ─────────── -->
<script>
(function () {
    var PRIVACY_URL = 'http://138.197.188.65/impressum-und-datenschutzerklarung/';

    function fixPrivacyLink() {
        var links = document.querySelectorAll(
            '#faz-consent .faz-notice-des a, ' +
            '#faz-consent [data-faz-tag="description"] a'
        );
        links.forEach(function (a) {
            a.setAttribute('href', PRIVACY_URL);
            a.setAttribute('target', '_blank');
            a.setAttribute('rel', 'noopener noreferrer');
            a.style.cursor = 'pointer';
            a.style.pointerEvents = 'auto';
            a.onclick = function (e) {
                e.stopPropagation();
                window.open(PRIVACY_URL, '_blank');
            };
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        fixPrivacyLink();
        var observer = new MutationObserver(fixPrivacyLink);
        observer.observe(document.body, { childList: true, subtree: true });
    });
}());
</script>

<!-- ── SCROLL FIX: block ALL scroll causes from Forminator ────────── -->
<script>
(function () {
    var active = false;
    var BLOCK_MS = 3000;
    var blockTimer = null;

    function activate() {
        active = true;
        clearTimeout(blockTimer);
        blockTimer = setTimeout(function () { active = false; }, BLOCK_MS);
    }

    var _origScrollIntoView = Element.prototype.scrollIntoView;
    Element.prototype.scrollIntoView = function () {
        if (active) return;
        if (this.closest && this.closest('#forminator-module-510')) return;
        _origScrollIntoView.apply(this, arguments);
    };

    var _origFocus = HTMLElement.prototype.focus;
    HTMLElement.prototype.focus = function () {
        if (active) {
            _origFocus.call(this, { preventScroll: true });
            return;
        }
        _origFocus.apply(this, arguments);
    };

    var _origScrollTo = window.scrollTo;
    var _origScroll   = window.scroll;
    window.scrollTo = function () { if (active) return; _origScrollTo.apply(window, arguments); };
    window.scroll   = function () { if (active) return; _origScroll.apply(window, arguments); };

    var _origPushState    = history.pushState;
    var _origReplaceState = history.replaceState;
    history.pushState = function (state, title, url) {
        if (active && url && String(url).indexOf('#') !== -1) return;
        _origPushState.apply(history, arguments);
    };
    history.replaceState = function (state, title, url) {
        if (active && url && String(url).indexOf('#') !== -1) return;
        _origReplaceState.apply(history, arguments);
    };

    document.addEventListener('submit', function (e) {
        if (e.target && e.target.closest && e.target.closest('#forminator-module-510')) activate();
    }, true);

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof jQuery !== 'undefined') {
            jQuery(document).on('forminator:form:submit:success forminator:form:510:submit:success', function () {
                activate();
            });
        }
    });
}());
</script>

<!-- ── FAZ toggle colour fix + newsletter popup + misc ───────────── -->
<script>
(function () {
    var TEAL      = '#1AAFBF';
    var CORAL     = '#EB574F';
    var TEAL_OFF  = 'rgba(255,255,255,0.3)';
    var DISMISS_MS = 5000;
    var dismissTimer = null;

    // Track the last form submitted — used to gate the newsletter popup
    var lastSubmittedFormId = null;

    /* ════════════════════════════════════════
       1. FAZ COOKIE TOGGLE — force teal
       ════════════════════════════════════════ */
    function fixFazToggles() {
        var checkboxes = document.querySelectorAll(
            '#faz-consent input[type="checkbox"], ' +
            '#faz-consent [role="switch"]'
        );

        checkboxes.forEach(function (cb) {
            var isOn = cb.checked ||
                       cb.getAttribute('aria-checked') === 'true' ||
                       cb.getAttribute('data-checked') === 'true';

            var candidates = [
                cb.nextElementSibling,
                cb.previousElementSibling,
                cb.parentElement
            ];

            candidates.forEach(function (el) {
                if (!el) return;
                el.style.setProperty('background-color', isOn ? TEAL : TEAL_OFF, 'important');
                el.style.setProperty('border-color',     isOn ? TEAL : TEAL_OFF, 'important');
                el.style.setProperty('transition', 'background-color 0.2s ease', 'important');
            });

            cb.addEventListener('change', function () {
                var on = this.checked;
                candidates.forEach(function (el) {
                    if (!el) return;
                    el.style.setProperty('background-color', on ? TEAL : TEAL_OFF, 'important');
                    el.style.setProperty('border-color',     on ? TEAL : TEAL_OFF, 'important');
                });
            });
        });

        var wrappers = document.querySelectorAll(
            '#faz-consent [aria-checked], ' +
            '#faz-consent [data-checked]'
        );
        wrappers.forEach(function (el) {
            var on = el.getAttribute('aria-checked') === 'true' ||
                     el.getAttribute('data-checked') === 'true';
            el.style.setProperty('background-color', on ? TEAL : TEAL_OFF, 'important');
            el.style.setProperty('border-color',     on ? TEAL : TEAL_OFF, 'important');
        });

        var allInside = document.querySelectorAll('#faz-consent *');
        allInside.forEach(function (el) {
            var bg = el.style.backgroundColor;
            if (!bg) return;
            var isBlue = (
                bg === 'rgb(0, 149, 255)'   ||
                bg === 'rgb(26, 115, 232)'  ||
                bg === 'rgb(37, 99, 235)'   ||
                bg === 'rgb(0, 0, 255)'     ||
                bg === 'blue'               ||
                bg === '#0095ff'            ||
                bg === '#1a73e8'            ||
                bg === '#2563eb'
            );
            if (isBlue) {
                el.style.setProperty('background-color', TEAL, 'important');
            }
        });
    }

    var fazObserver = new MutationObserver(function (mutations) {
        var shouldRun = false;
        mutations.forEach(function (m) {
            if (m.addedNodes.length) shouldRun = true;
            if (m.type === 'attributes') shouldRun = true;
        });
        if (shouldRun) fixFazToggles();
    });

    document.addEventListener('DOMContentLoaded', function () {
        fixFazToggles();
        fazObserver.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['checked', 'aria-checked', 'data-checked', 'style', 'class']
        });
    });

    setTimeout(fixFazToggles, 500);
    setTimeout(fixFazToggles, 1500);
    setTimeout(fixFazToggles, 3000);

    /* ════════════════════════════════════════
       2. FORMINATOR BUTTON HOVER
       ════════════════════════════════════════ */
    function initFormButtonHover() {
        var buttons = document.querySelectorAll(
            '#forminator-module-510 .forminator-button-submit, ' +
            '.newsletter-form .forminator-button-submit'
        );
        buttons.forEach(function (btn) {
            btn.addEventListener('mouseenter', function () {
                this.style.setProperty('background-color', CORAL, 'important');
                this.style.setProperty('background',       CORAL, 'important');
            });
            btn.addEventListener('mouseleave', function () {
                this.style.removeProperty('background-color');
                this.style.removeProperty('background');
            });
        });
    }

    /* ════════════════════════════════════════
       3. NEWSLETTER SUCCESS POPUP
       — Tracks which form was submitted last
       — Only shows popup if form 510 was last
       ════════════════════════════════════════ */
    var popup    = document.getElementById('newsletter-success-popup');
    var bar      = document.getElementById('nsp-bar');
    var closeBtn = popup ? popup.querySelector('.nsp-close') : null;

    function showPopup() {
        if (!popup) return;
        bar.style.transition = 'none';
        bar.style.transform  = 'scaleX(1)';
        void bar.offsetWidth;
        bar.style.transition = 'transform ' + DISMISS_MS + 'ms linear';
        bar.style.transform  = 'scaleX(0)';
        popup.classList.add('is-visible');
        clearTimeout(dismissTimer);
        dismissTimer = setTimeout(hidePopup, DISMISS_MS);
    }

    function hidePopup() {
        if (!popup) return;
        popup.classList.remove('is-visible');
        clearTimeout(dismissTimer);
    }

    if (closeBtn) closeBtn.addEventListener('click', hidePopup);

    function bindForminatorSuccess() {
        // Track which form was last submitted via native form submit event
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if ( form.closest('#forminator-module-510') ) {
                lastSubmittedFormId = '510';
            } else if ( form.closest('#forminator-module-668') ) {
                lastSubmittedFormId = '668';
            }
        }, true);

        if (typeof jQuery !== 'undefined') {
            jQuery(document).on('forminator:form:submit:success', function (e, formData) {
                // Use formData.form_id if available, otherwise fall back to lastSubmittedFormId
                var fid = (formData && formData.form_id)
                    ? String(formData.form_id)
                    : lastSubmittedFormId;

                if ( fid === '510' ) showPopup();
            });
            jQuery(document).on('forminator:form:510:submit:success', showPopup);
        }

        // MutationObserver — watches ONLY #forminator-module-510
        var formWrap = document.getElementById('forminator-module-510');
        if (!formWrap) return;

        var newsletter510Observer = new MutationObserver(function (mutations) {
            // Only trigger if form 510 was the last submitted
            if ( lastSubmittedFormId !== '510' ) return;

            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType !== 1) return;
                    if (
                        node.classList.contains('forminator-success') ||
                        node.classList.contains('forminator-response-message') ||
                        (node.querySelector && node.querySelector('.forminator-success'))
                    ) showPopup();
                });
                if (
                    mutation.type === 'attributes' &&
                    mutation.attributeName === 'aria-hidden' &&
                    mutation.target.getAttribute('aria-hidden') === 'false' &&
                    mutation.target.classList.contains('forminator-response-message')
                ) showPopup();
            });
        });

        newsletter510Observer.observe(formWrap, {
            childList: true, subtree: true,
            attributes: true, attributeFilter: ['aria-hidden', 'class']
        });
    }

    /* ════════════════════════════════════════
       4. SUB-MENU INDENT + HOVER UNDERLINE + CURSOR
       ════════════════════════════════════════ */
    function indentSubMenuLinks() {
        var links = document.querySelectorAll(
            '.footer-nav-wrapper .footer-nav-list > li .sub-menu li a, ' +
            '.col--nav .footer-nav-list > li .sub-menu li a'
        );
        links.forEach(function (a) {
            a.style.setProperty('padding-left',   '16px', 'important');
            a.style.setProperty('padding-top',    '5px',  'important');
            a.style.setProperty('padding-bottom', '5px',  'important');
            a.style.setProperty('padding-right',  '0',    'important');
            a.style.setProperty('cursor', 'pointer', 'important');

            a.addEventListener('mouseenter', function () {
                this.style.setProperty('text-decoration',       'underline', 'important');
                this.style.setProperty('text-underline-offset', '3px',       'important');
                this.style.setProperty('text-decoration-color', '#ffffff',   'important');
            });
            a.addEventListener('mouseleave', function () {
                this.style.setProperty('text-decoration', 'none', 'important');
            });
        });
    }

    /* ════════════════════════════════════════
       5. BOOT
       ════════════════════════════════════════ */
    function init() {
        initFormButtonHover();
        bindForminatorSuccess();
        indentSubMenuLinks();
        fixFazToggles();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    setTimeout(initFormButtonHover, 500);
    setTimeout(initFormButtonHover, 1500);
    setTimeout(indentSubMenuLinks,  500);
    setTimeout(indentSubMenuLinks,  1500);

    /* Re-init after Barba.js page transitions */
    document.addEventListener('barba:after', init);
    if (typeof barba !== 'undefined') {
        barba.hooks.after(init);
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof barba !== 'undefined') barba.hooks.after(init);
        });
    }
}());
</script>

<?php get_footer(); ?>