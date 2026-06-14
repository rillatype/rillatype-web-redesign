<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}


$text_title_single = esc_html__( 'One Comment', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_title_single') ) {
	$text_title_single = larisdigital_theme_mod('larisdigital_comments_title_single');
}
$text_title_plural = esc_html__( '%s Comments', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_title_plural') ) {
	$text_title_plural = larisdigital_theme_mod('larisdigital_comments_title_plural');
}
$text_name = esc_html__( 'Your Name', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_name') ) {
	$text_name = larisdigital_theme_mod('larisdigital_comments_form_name');
}
$text_email = esc_html__( 'Your Email', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_email') ) {
	$text_email = larisdigital_theme_mod('larisdigital_comments_form_email');
}
$text_website = esc_html__( 'Your Website', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_website') ) {
	$text_website = larisdigital_theme_mod('larisdigital_comments_form_website');
}
$text_comment = esc_html__( 'Your Comment', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_comment') ) {
	$text_comment = larisdigital_theme_mod('larisdigital_comments_form_comment');
}
$text_required = esc_html__('Required fields are marked %s', 'larisdigital-wp');
if ( larisdigital_theme_mod('larisdigital_comments_form_required') ) {
	$text_required = larisdigital_theme_mod('larisdigital_comments_form_required');
}
$text_notes = esc_html__( 'Your email address will not be published.', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_notes') ) {
	$text_notes = larisdigital_theme_mod('larisdigital_comments_form_notes');
}
$text_titlereply = esc_html__( 'Leave a Reply', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_title_reply') ) {
	$text_titlereply = larisdigital_theme_mod('larisdigital_comments_form_title_reply');
}
$text_titlereplyto = esc_html__( 'Leave a Reply to %s', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_title_reply_to') ) {
	$text_titlereplyto = larisdigital_theme_mod('larisdigital_comments_form_title_reply_to');
}
$text_cancelreply = esc_html__( 'Cancel reply', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_cancel_reply_link') ) {
	$text_cancelreply = larisdigital_theme_mod('larisdigital_comments_form_cancel_reply_link');
}
$text_submit = esc_html__( 'Post Comment', 'larisdigital-wp' );
if ( larisdigital_theme_mod('larisdigital_comments_form_label_submit') ) {
	$text_submit = larisdigital_theme_mod('larisdigital_comments_form_label_submit');
}

if ( ! function_exists( 'larisdigital_comment' ) ) :
function larisdigital_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'larisdigital-wp' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'larisdigital-wp' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="comment-body-inner">

				<?php echo get_avatar( $comment, 64, '', '', array( 'class' => 'comment-avatar alignright' ) ); ?>
					
				<h5 class="comment-author"><?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?></h5>

				<p class="comment-meta">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'larisdigital-wp' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a> 
					<?php edit_comment_link( __( '<span style="margin-left: 5px;" class="fa fa-edit"></span> Edit', 'larisdigital-wp' ), '<span class="edit-link">', '</span>' ); ?>
				</p>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation alert alert-warning"><?php _e( 'Your comment is awaiting moderation.', 'larisdigital-wp' ); ?></p>
				<?php endif; ?>
				
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				
				<?php if ( $reply = get_comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ) : ?>
				<footer class="reply comment-reply">
					<?php echo str_replace( 'comment-reply-link', 'comment-reply-link btn btn-secondary btn-sm', $reply ); ?>
				</footer>
				<?php endif; ?>

			</div>

		</article>

	<?php
	endif;
}
endif;

?>

<div id="comments" class="comments-area card">

	<div class="comments-area-inner card-body">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$number = get_comments_number();
			echo ( $number == 1 ? $text_title_single : sprintf( $text_title_plural, number_format_i18n( $number ) ) );
			?>
		</h3>

		<?php if ( 1 < get_comment_pages_count() && get_option( 'page_comments' ) ) :  ?>
		<nav id="comment-nav-above" class="comment-navigation comment-navigation-above">
			<h5 class="screen-reader-text"><?php _e( 'Comment navigation', 'larisdigital-wp' ); ?></h5>
			<ul class="list-unstyled clearfix">
				<li class="nav-item nav-previous float-left"><?php previous_comments_link( __( '&larr; Older Comments', 'larisdigital-wp' ) ); ?></li>
				<li class="nav-item nav-next float-right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'larisdigital-wp' ) ); ?></li>
			</ul>
		</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'larisdigital_comment' ) ); ?>
		</ol>

		<?php if ( 1 < get_comment_pages_count() && get_option( 'page_comments' ) ) : ?>
		<nav class="comment-navigation comment-navigation-below">
			<h5 class="screen-reader-text"><?php _e( 'Comment navigation', 'larisdigital-wp' ); ?></h5>
			<ul class="list-unstyled clearfix">
				<li class="nav-item nav-previous float-left"><?php previous_comments_link( __( '&larr; Older Comments', 'larisdigital-wp' ) ); ?></li>
				<li class="nav-item nav-next float-right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'larisdigital-wp' ) ); ?></li>
			</ul>
		</nav>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'larisdigital-wp' ); ?></p>
	<?php endif; ?>

	<?php 
	$commenter = wp_get_current_commenter();
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = current_theme_supports( 'html5', 'comment-form' ) ? true : false;
	$fields   =  array(
		'author' 			=> '<div class="row"><div class="col-md-6"><div class="input-group mb-3 comment-form-author">' . '<div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"/></svg></span></div>' . '<input class="form-control" id="author" name="author" type="text" placeholder="' . esc_attr( $text_name ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>',
		'email'  			=> '<div class="col-md-6"><div class="input-group mb-3 comment-form-email">' . '<div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"/></svg></span></div>' . '<input class="form-control" id="email" name="email" type="email" placeholder="' . esc_html( $text_email ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div></div>',
		'url'    			=> '<div class="input-group mb-3 comment-form-url">' . '<div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z"/></svg></span></div>' . '<input class="form-control" id="url" name="url" type="url" placeholder="' . esc_html( $text_website ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
	);
	$required_text = sprintf( ' ' . $text_required, '<span class="required">*</span>' );
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$args = array(
		'fields'               => $fields,
		'comment_field'        => '<p class="form-group comment-form-comment"><textarea class="form-control" id="comment" name="comment" placeholder="' . esc_attr( $text_comment ) . '" cols="45" rows="5" aria-required="true"></textarea></p>', 
		'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . $text_notes . '</span>'. ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'commentsubmit',
		'class_submit'         => 'submit btn btn-primary',
		'title_reply'          => $text_titlereply,
		'title_reply_to'       => $text_titlereplyto,
		'cancel_reply_link'    => $text_cancelreply,
		'label_submit'         => $text_submit,
	);
	
	comment_form( $args ); 
	?>

	</div><!-- .comments-area-inner -->

</div><!-- #comments -->
