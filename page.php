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

<?php the_content(); ?>

<?php get_footer(); ?>