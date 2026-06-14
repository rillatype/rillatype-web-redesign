<?php 
/**
 * Shop Filters, frontend only
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'TUTOR_VERSION') ) {
	return;
}

/**
 * TutorLMS - Customizer Panel
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_tutor_customize_controls' );
function larisdigital_tutor_customize_controls( $controls ) {
	$controls['larisdigital_tutor_panel_settings'] = array(
		'title'    => esc_html__( 'Theme Settings - TutorLMS', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_panel_settings',
		'type'     => 'panel',
		'priority' => 15,
	);

	return $controls;
}

/**
 * TutorLMS - General
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_tutor_customize_controls_general' );
function larisdigital_tutor_customize_controls_general( $controls ) {

	$controls['larisdigital_tutor_section_general'] = array(
		'title'    => esc_html__( 'TutorLMS - General', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_section_general',
		'panel'    => 'larisdigital_tutor_panel_settings',
		'type'     => 'section',
		'priority' => 10,
	);

	$controls['larisdigital_tutor_heading_color_style'] = array(
		'label'				=> esc_html__( 'Color Style', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_heading_color_style',
		'section'			=> 'larisdigital_tutor_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_tutor_primary_color'] = array(
		'label'   			=> esc_html__( 'Primary Color', 'larisdigital-wp' ),
		'setting'  			=> 'tutor_primary_color',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'color',
	);

	$controls['larisdigital_tutor_primary_hover_color'] = array(
		'label'   			=> esc_html__( 'Primary Hover Color', 'larisdigital-wp' ),
		'setting'  			=> 'tutor_primary_hover_color',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'color',
	);

	$controls['larisdigital_tutor_text_color'] = array(
		'label'   			=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'tutor_text_color',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'color',
	);

	$controls['larisdigital_tutor_light_color'] = array(
		'label'   			=> esc_html__( 'Light Color', 'larisdigital-wp' ),
		'setting'  			=> 'tutor_light_color',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'color',
	);

	$controls['larisdigital_tutor_heading_youtube_player'] = array(
		'label'				=> esc_html__( 'Youtube Player', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_heading_youtube_player',
		'section'			=> 'larisdigital_tutor_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_tutor_disable_default_player_youtube'] = array(
		'label'   			=> esc_html__( 'ENABLE Youtube Player', 'larisdigital-wp' ),
		'description'   	=> esc_html__( 'Disable this option to use Tutor LMS video player for Youtube video.', 'larisdigital-wp' ),
		'setting'  			=> 'disable_default_player_youtube',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'checkbox',
	);

	$controls['larisdigital_tutor_heading_vimeo_player'] = array(
		'label'				=> esc_html__( 'Vimeo Player', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_heading_vimeo_player',
		'section'			=> 'larisdigital_tutor_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_tutor_disable_default_player_vimeo'] = array(
		'label'   			=> esc_html__( 'ENABLE Vimeo Player', 'larisdigital-wp' ),
		'description'   	=> esc_html__( 'Disable this option to use Tutor LMS video player for Vimeo video.', 'larisdigital-wp' ),
		'setting'  			=> 'disable_default_player_vimeo',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'checkbox',
	);

	$controls['larisdigital_tutor_heading_sejoli'] = array(
		'label'				=> esc_html__( 'Sejoli', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_heading_sejoli',
		'section'			=> 'larisdigital_tutor_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_tutor_sejoli_button_text'] = array(
		'label'   			=> esc_html__( 'Course Button Text For Sejoli Product', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_sejoli_button_text',
		'section'  			=> 'larisdigital_tutor_section_general',
		'type'     			=> 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Join Now', 'larisdigital-wp' ),
		),
	);

	return $controls;
}

/**
 * TutorLMS - Courses Page
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_tutor_customize_controls_archive' );
function larisdigital_tutor_customize_controls_archive( $controls ) {

	$controls['larisdigital_tutor_section_archive'] = array(
		'title'    => esc_html__( 'TutorLMS - Courses Page', 'larisdigital-wp' ),
		'description' => '',
		'setting'  => 'larisdigital_tutor_section_archive',
		'panel'    => 'larisdigital_tutor_panel_settings',
		'type'     => 'section',
		'priority' => 20,
	);

	$controls['larisdigital_tutor_heading_archive_site_header'] = array(
		'label'    => esc_html__( 'Site Header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_archive_site_header',
		'section'  => 'larisdigital_tutor_section_archive',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_tutor_archive_title4header'] = array(
		'label'    => esc_html__( 'Use custom title for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_archive_title4header',
		'section'  => 'larisdigital_tutor_section_archive',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_tutor_archive_title'] = array(
		'label'    => esc_html__( 'Courses page title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_archive_title',
		'section'  => 'larisdigital_tutor_section_archive',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Courses', 'larisdigital-wp' ),
		),
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_tutor_archive_description'] = array(
		'label'    => esc_html__( 'Courses page description', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_archive_description',
		'section'  => 'larisdigital_tutor_section_archive',
		'type'     => 'text',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_tutor_heading_archive_layout'] = array(
		'label'    => esc_html__( 'Courses Page Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_archive_layout',
		'section'  => 'larisdigital_tutor_section_archive',
		'type'     => 'heading',
	);

	$controls['larisdigital_tutor_course_filter'] = array(
		'label'				=> esc_html__( 'ENABLE Course Filter', 'larisdigital-wp' ),
		'setting'  			=> 'course_archive_filter',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	// $controls['larisdigital_tutor_course_filter_search'] = array(
	// 	'label'				=> esc_html__( 'ENABLE Course Filter - Search', 'larisdigital-wp' ),
	// 	'setting'  			=> 'supported_course_filters',
	// 	'setting2'  		=> 'search',
	// 	'setting_type' 		=> 'option_mod2',
	// 	'setting_db' 		=> 'tutor_option',
	// 	'section'			=> 'larisdigital_tutor_section_archive',
	// 	'type'     			=> 'select',
	// 	'choices'  			=> array(
	// 		'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
	// 		'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
	// 	),
	// 	'active_callback'	=> 'larisdigital_tutor_callback_course_filters_is_active',
	// );

	// $controls['larisdigital_tutor_course_filter_category'] = array(
	// 	'label'				=> esc_html__( 'ENABLE Course Filter - Category', 'larisdigital-wp' ),
	// 	'setting'  			=> 'supported_course_filters',
	// 	'setting2'  		=> 'category',
	// 	'setting_type' 		=> 'option_mod2',
	// 	'setting_db' 		=> 'tutor_option',
	// 	'section'			=> 'larisdigital_tutor_section_archive',
	// 	'type'     			=> 'select',
	// 	'choices'  			=> array(
	// 		'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
	// 		'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
	// 	),
	// 	'active_callback'	=> 'larisdigital_tutor_callback_course_filters_is_active',
	// );

	// $controls['larisdigital_tutor_course_filter_tag'] = array(
	// 	'label'				=> esc_html__( 'ENABLE Course Filter - Tag', 'larisdigital-wp' ),
	// 	'setting'  			=> 'supported_course_filters',
	// 	'setting2'  		=> 'tag',
	// 	'setting_type' 		=> 'option_mod2',
	// 	'setting_db' 		=> 'tutor_option',
	// 	'section'			=> 'larisdigital_tutor_section_archive',
	// 	'type'     			=> 'select',
	// 	'choices'  			=> array(
	// 		'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
	// 		'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
	// 	),
	// 	'active_callback'	=> 'larisdigital_tutor_callback_course_filters_is_active',
	// );

	// $controls['larisdigital_tutor_course_filter_difficulty_level'] = array(
	// 	'label'				=> esc_html__( 'ENABLE Course Filter - Difficulty Level', 'larisdigital-wp' ),
	// 	'setting'  			=> 'supported_course_filters',
	// 	'setting2'  		=> 'difficulty_level',
	// 	'setting_type' 		=> 'option_mod2',
	// 	'setting_db' 		=> 'tutor_option',
	// 	'section'			=> 'larisdigital_tutor_section_archive',
	// 	'type'     			=> 'select',
	// 	'choices'  			=> array(
	// 		'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
	// 		'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
	// 	),
	// 	'active_callback'	=> 'larisdigital_tutor_callback_course_filters_is_active',
	// );

	// $controls['larisdigital_tutor_course_filter_price_type'] = array(
	// 	'label'				=> esc_html__( 'ENABLE Course Filter - Price Type', 'larisdigital-wp' ),
	// 	'setting'  			=> 'supported_course_filters',
	// 	'setting2'  		=> 'price_type',
	// 	'setting_type' 		=> 'option_mod2',
	// 	'setting_db' 		=> 'tutor_option',
	// 	'section'			=> 'larisdigital_tutor_section_archive',
	// 	'type'     			=> 'select',
	// 	'choices'  			=> array(
	// 		'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
	// 		'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
	// 	),
	// 	'active_callback'	=> 'larisdigital_tutor_callback_course_filters_is_active',
	// );

	$controls['larisdigital_tutor_courses_col_per_row'] = array(
		'label'				=> esc_html__( 'Number of courses per row', 'larisdigital-wp' ),
		'setting'  			=> 'courses_col_per_row',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'4' => '4',
			'3' => '3',
			'2' => '2',
			'1' => '1',
		),
	);

	$controls['larisdigital_tutor_courses_per_page'] = array(
		'label'				=> esc_html__( 'Number of courses per page', 'larisdigital-wp' ),
		'setting'  			=> 'courses_per_page',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'				=> 'number',
	);

	$controls['larisdigital_tutor_heading_archive_elements'] = array(
		'label'    => esc_html__( 'Courses Page Elements', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_archive_elements',
		'section'  => 'larisdigital_tutor_section_archive',
		'type'     => 'heading',
	);

	$controls['larisdigital_tutor_archive_filter_bar_enable'] = array(
		'label'				=> esc_html__( 'ENABLE course top filter (ordering dropdown)', 'larisdigital-wp' ),
		'setting'  			=> 'course_archive_filter_sorting',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_archive_rating_disable'] = array(
		'label'				=> esc_html__( 'DISABLE course rating', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_archive_rating_disable',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_tutor_archive_title_disable'] = array(
		'label'				=> esc_html__( 'DISABLE course title', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_archive_title_disable',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_tutor_archive_meta_disable'] = array(
		'label'				=> esc_html__( 'DISABLE course meta', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_archive_meta_disable',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_tutor_archive_footer_disable'] = array(
		'label'				=> esc_html__( 'DISABLE course footer (price & CTA)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_tutor_archive_footer_disable',
		'section'			=> 'larisdigital_tutor_section_archive',
		'type'				=> 'checkbox',
	);

	return $controls;
}

/**
 * TutorLMS - Single Course
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_tutor_customize_controls_course' );
function larisdigital_tutor_customize_controls_course( $controls ) {

	$controls['larisdigital_tutor_section_course'] = array(
		'title'    => esc_html__( 'TutorLMS - Single Course', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Single Course', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_tutor_section_course',
		'panel'    => 'larisdigital_tutor_panel_settings',
		'type'     => 'section',
		'priority' => 30,
	);

	$controls['larisdigital_tutor_heading_course_site_header'] = array(
		'label'    => esc_html__( 'Site Header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_course_site_header',
		'section'  => 'larisdigital_tutor_section_course',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_tutor_course_header_hide'] = array(
		'label'    => esc_html__( 'HIDE Site Header on All Single Course', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_course_header_hide',
		'section'  => 'larisdigital_tutor_section_course',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_tutor_course_title4header'] = array(
		'label'    => esc_html__( 'Use course title for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_course_title4header',
		'section'  => 'larisdigital_tutor_section_course',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_tutor_callback_header_course_is_active',
	);

	$controls['larisdigital_tutor_heading_course_elements'] = array(
		'label'    => esc_html__( 'Single Course Elements', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_course_elements',
		'section'  => 'larisdigital_tutor_section_course',
		'type'     => 'heading',
	);

	$controls['larisdigital_tutor_display_course_instructors'] = array(
		'label'				=> esc_html__( 'Instructor Info', 'larisdigital-wp' ),
		'setting'  			=> 'display_course_instructors',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_q_and_a_on_course'] = array(
		'label'				=> esc_html__( 'Q&A', 'larisdigital-wp' ),
		'setting'  			=> 'enable_q_and_a_on_course',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_author'] = array(
		'label'				=> esc_html__( 'Author', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_author',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_level'] = array(
		'label'				=> esc_html__( 'Level', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_level',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_share'] = array(
		'label'				=> esc_html__( 'Social Share', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_share',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_duration'] = array(
		'label'				=> esc_html__( 'Duration', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_duration',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_total_enrolled'] = array(
		'label'				=> esc_html__( 'Total Enrolled', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_total_enrolled',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_update_date'] = array(
		'label'				=> esc_html__( 'Update Date', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_update_date',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_progress_bar'] = array(
		'label'				=> esc_html__( 'Progress Bar', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_progress_bar',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_material'] = array(
		'label'				=> esc_html__( 'Material', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_material',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_about'] = array(
		'label'				=> esc_html__( 'About', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_about',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_description'] = array(
		'label'				=> esc_html__( 'Description', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_description',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_benefits'] = array(
		'label'				=> esc_html__( 'Benefits', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_benefits',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_requirements'] = array(
		'label'				=> esc_html__( 'Requirements', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_requirements',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_target_audience'] = array(
		'label'				=> esc_html__( 'Target Audience', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_target_audience',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_announcements'] = array(
		'label'				=> esc_html__( 'Announcements', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_announcements',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_enable_course_review'] = array(
		'label'				=> esc_html__( 'Review', 'larisdigital-wp' ),
		'setting'  			=> 'enable_course_review',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_course',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	return $controls;
}

/**
 * TutorLMS - Single Course
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_tutor_customize_controls_lesson' );
function larisdigital_tutor_customize_controls_lesson( $controls ) {

	$controls['larisdigital_tutor_section_lesson'] = array(
		'title'    => esc_html__( 'TutorLMS - Single Lesson', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Single Lesson', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_tutor_section_lesson',
		'panel'    => 'larisdigital_tutor_panel_settings',
		'type'     => 'section',
		'priority' => 50,
	);

	$controls['larisdigital_tutor_heading_spotlight_mode'] = array(
		'label'    => esc_html__( 'Spotlight Mode', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_spotlight_mode',
		'section'  => 'larisdigital_tutor_section_lesson',
		'type'     => 'heading',
	);

	$controls['larisdigital_tutor_disable_enable_spotlight_mode'] = array(
		'label'				=> esc_html__( 'ENABLE Spotlight Mode', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'This will hide the header and the footer and enable spotlight (full screen) mode when students view lessons.', 'larisdigital-wp' ),
		'setting'  			=> 'enable_spotlight_mode',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_lesson',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_tutor_heading_autoload'] = array(
		'label'    => esc_html__( 'Automatic Loading', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_tutor_heading_autoload',
		'section'  => 'larisdigital_tutor_section_lesson',
		'type'     => 'heading',
	);

	$controls['larisdigital_tutor_autoload_next_course_content'] = array(
		'label'				=> esc_html__( 'Automatically load next course content', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'Enabling this feature will load next course content automatically after finishing current video.', 'larisdigital-wp' ),
		'setting'  			=> 'autoload_next_course_content',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> 'tutor_option',
		'section'			=> 'larisdigital_tutor_section_lesson',
		'type'     			=> 'select',
		'choices'  			=> array(
			'on' 			=> esc_html__( 'Yes', 'larisdigital-wp' ),
			'off' 			=> esc_html__( 'No', 'larisdigital-wp' ),
		),
	);

	return $controls;
}

function larisdigital_tutor_callback_header_course_is_active() {
	return ( larisdigital_theme_mod( 'larisdigital_tutor_header_hide' ) || larisdigital_theme_mod( 'larisdigital_tutor_course_header_hide' ) ) ? false : true;
}

function larisdigital_tutor_callback_archive_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_archive_sidebar_layout' );
	return ( 'none' != $layout ) ? true : false;
}

function larisdigital_tutor_callback_archive_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_archive_sidebar_layout' );
	return ( 'none' == $layout ) ? true : false;
}

function larisdigital_tutor_callback_course_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_sidebar_layout' );
	return ( 'none' != $layout ) ? true : false;
}

function larisdigital_tutor_callback_course_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_sidebar_layout' );
	return ( 'none' == $layout ) ? true : false;
}

function larisdigital_tutor_callback_course_filters_is_active() {
	$tutor_option = get_option('tutor_option');
	return isset( $tutor_option['course_archive_filter'] ) && $tutor_option['course_archive_filter'] == 'on' ? true : false;
}

add_action( 'customize_controls_print_scripts', 'larisdigital_tutor_customize_print_scripts', 30 );
function larisdigital_tutor_customize_print_scripts() {
	$archive_page = get_post_type_archive_link( 'courses' );

	$archive_section = apply_filters( 'larisdigital_tutor_customize_preview_archive', array(
		'larisdigital_tutor_section_archive' => 'larisdigital_tutor_section_archive',
	) );
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php if ( $archive_page && ! empty( $archive_section ) ) : foreach ( $archive_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $archive_page ); ?>' );
			}
		} );
	} );
<?php endforeach; endif; ?>
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_tutor_customize_scripts_preview_course', 30 );
function larisdigital_tutor_customize_scripts_preview_course() {
	$course_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'courses',
		'orderby' => 'date',
		'order' => 'ASC',
		'meta_query' => array(
			// array(
			// 	'key'     => '_layout_custom',
			// 	'value'   => '',
			// 	'compare' => 'NOT EXISTS',
			// ),
			array(
				'key'     => '_elementor_edit_mode',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
			// array(
			// 	'key'     => '_wp_page_template',
			// 	'value'   => '',
			// 	'compare' => 'NOT EXISTS',
			// ),
		),
		'fields' => 'ids',
	) );
	$course_url = !empty( $course_ids ) ? get_permalink( reset( $course_ids ) ) : '';
	$course_section = apply_filters( 'larisdigital_tutor_customize_preview_course', array(
		'larisdigital_tutor_section_general' => 'larisdigital_tutor_section_general',
		'larisdigital_tutor_section_course' => 'larisdigital_tutor_section_course',
	) );
	if ( empty( $course_url ) ) {
		return;
	}
	if ( empty( $course_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $course_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $course_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_tutor_customize_scripts_preview_lesson', 30 );
function larisdigital_tutor_customize_scripts_preview_lesson() {
	$course_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'lesson',
		'orderby' => 'date',
		'order' => 'ASC',
		'meta_query' => array(
		),
		'fields' => 'ids',
	) );
	$course_url = !empty( $course_ids ) ? get_permalink( reset( $course_ids ) ) : '';
	$course_section = apply_filters( 'larisdigital_tutor_customize_preview_lesson', array(
		'larisdigital_tutor_section_lesson' => 'larisdigital_tutor_section_lesson',
	) );
	if ( empty( $course_url ) ) {
		return;
	}
	if ( empty( $course_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $course_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $course_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}
