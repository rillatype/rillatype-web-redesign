<?php
/**
 * The Template for displaying single product
 *
 * @package Rillatype_Theme
 */

get_header();

while (have_posts()) :
  the_post();
  wc_get_template_part('content', 'single-product');
endwhile;

get_footer();
