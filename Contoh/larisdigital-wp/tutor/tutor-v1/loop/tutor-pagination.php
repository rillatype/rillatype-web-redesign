<?php
/**
 * A single course loop pagination
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action('tutor_course/archive/pagination/before');  ?>

<?php larisdigital_pagination( '', larisdigital_theme_mod( 'larisdigital_pagination_alignment' ) ); ?>

<?php do_action('tutor_course/archive/pagination/after');  ?>
