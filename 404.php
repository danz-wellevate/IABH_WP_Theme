<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="main-content">

<div class="" id="error-404-wrapper">

    <div class="no-page-wrapper">
        <div class="header-style">
            <h1 class="gradient">404</h1>
            <p class="subheader">Seite nicht gefunden</p>
            <p class="description">
                Die gesuchte Seite existiert nicht oder ein anderer Fehler ist aufgetreten.
                <a href="javascript:history.back()">Zurück</a>, oder besuche die
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Startseite</a>.
            </p>
        </div>
    </div>

</div><!-- #error-404-wrapper -->