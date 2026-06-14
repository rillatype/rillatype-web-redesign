<?php
/**
 * Metabox
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class LarisDigital_Metabox {
	var $meta_box;
	var $fields;

	public function __construct( $meta_box ) {
		if ( !is_admin( ) ) return;
		$this->meta_box = $meta_box;
		$this->fields = &$this->meta_box['fields'];
		$this->types = array_unique( wp_list_pluck( $this->fields, 'type' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_menu() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		add_action( 'admin_print_scripts-post.php', array( $this, 'admin_print_scripts' ) );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'admin_print_scripts' ) );
	}

	public function add_meta_box() {
		add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'callback' ), $this->meta_box['screen'], $this->meta_box['context'], $this->meta_box['priority'] );		
	}

	public function callback( $post ) {
		wp_nonce_field( $this->meta_box['id'], $this->meta_box['id'].'_nonce' );
		echo $this->generate( $this->fields, $post, $this->meta_box['context'] );
	}

	private function generate( $fields, $post, $context = 'normal' ) {
		$output = '';
		foreach ( $fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, $field['id'], true );
			switch ( $field['type'] ) {
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1"> ',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;
				case 'media':
					$input = sprintf(
						'<input class="widefat" id="%s" name="%s" type="text" value="%s"> <input class="button larisdigital-metabox-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$field['id'],
						$field['id'],
						$db_value,
						$field['id'],
						$field['id']
					);
					break;
				case 'radio':
					$input = '<fieldset>';
					$input .= '<legend class="screen-reader-text">' . $field['label'] . '</legend>';
					$i = 0;
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<label><input %s id="%s" name="%s" type="radio" value="%s"> %s</label>%s',
							$db_value === $field_value ? 'checked' : '',
							$field['id'],
							$field['id'],
							$field_value,
							$value,
							$i < count( $field['options'] ) - 1 ? '<br>' : ''
						);
						$i++;
					}
					$input .= '</fieldset>';
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$field['id'],
						$field['id']
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				case 'textarea':
					$input = sprintf(
						'<textarea id="%s" name="%s" rows="5">%s</textarea>',
						$field['id'],
						$field['id'],
						$db_value
					);
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			if ( $field['type'] == 'checkbox' ) {
				if ( 'side' == $context ) {
					$output .= '<p>' . $input . '<label for="' . $field['id'] . '">' . $field['label2'] . '</label></p>';
				}
				else {
					$output .= sprintf(
						'<tr><th scope="row">%s</th><td>%s %s</td></tr>',
						$label,
						$input,
						$field['label2']
					);
				}
			}
			else {
				if ( 'side' == $context ) {
					$output .= '<p>' . $label . '<br>' . $input . '</p>';
				}
				else {
					$output .= sprintf(
						'<tr><th scope="row">%s</th><td>%s</td></tr>',
						$label,
						$input
					);
				}
			}
		}
		if ( 'side' != $context ) {
			$output = '<table class="form-table"><tbody>' . $output . '</tbody></table>';
		}
		return $output;
	}

	public function save_post( $post_id, $post ) {
		$id = $this->meta_box['id'];

		if ( ! isset( $_POST["{$id}_nonce"] ) )
			return $post_id;

		if ( !wp_verify_nonce( $_POST["{$id}_nonce"], $id ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		$this->save( $this->fields, $post_id, $_POST );
	}

	private function save( $fields, $post_id ) {
		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
			}
			else {
				delete_post_meta( $post_id, $field['id'] );
			}
		}
	}

	public function admin_print_scripts(  ) {
		$version = '0.1.0';
		wp_enqueue_script( 'larisdigital-metabox', get_template_directory_uri() . '/assets/js/metabox.min.js', array('jquery'), $version, true );
	}
}
