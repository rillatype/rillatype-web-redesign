<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Video extends Widget_Base {

	public function get_name() {
		return 'tp_video';
	}

	public function get_title() {
		return __( 'TP - Video', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Video', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'notes',
			[
				'raw' => __( 'IMPORTANT! We use faster approach, using direct iframe output. Elementor built-in Video widget uses oEmbed.', 'larisdigital-wp' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'video_type',
			[
				'label' => __( 'Video Type', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'youtube' => __( 'Youtube', 'larisdigital-wp' ),
					'facebook' => __( 'Facebook', 'larisdigital-wp' ),
					'vimeo' => __( 'Vimeo', 'larisdigital-wp' ),
					'dailymotion' => __( 'Dailymotion', 'larisdigital-wp' ),
				],
				'default' => 'youtube',
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => __( 'Youtube Video URL', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter YouTube Video URL', 'larisdigital-wp' ),
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

		$this->add_control(
			'facebook_url',
			[
				'label' => __( 'Facebook Video URL', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Facebook Video URL', 'larisdigital-wp' ),
				'default' => 'https://www.facebook.com/elemntor/videos/1986137578363858/',
				'label_block' => true,
				'condition' => [
					'video_type' => 'facebook',
				],
			]
		);

		$this->add_control(
			'vimeo_url',
			[
				'label' => __( 'Vimeo Video URL', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Vimeo Video URL', 'larisdigital-wp' ),
				'default' => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'dailymotion_url',
			[
				'label' => __( 'Dailymotion Video URL', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Dailymotion Video URL', 'larisdigital-wp' ),
				'default' => 'https://www.dailymotion.com/video/x6koazf',
				'label_block' => true,
				'condition' => [
					'video_type' => 'dailymotion',
				],
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ar169' => '16:9',
					'ar43' => '4:3',
					'ar32' => '3:2',
					'ar11' => '1:1',
					'ar23' => '2:3',
					'ar34' => '3:4',
					'ar916' => '9:16',
				],
				'default' => 'ar169',
				'prefix_class' => 'tp-aspect-ratio-',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'larisdigital-wp' ),
				'description' => __( 'Autoplay is not supported in some browsers.', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => ['youtube','facebook','vimeo','dailymotion'],
				],
			]
		);

		$this->add_control(
			'mute',
			[
				'label' => __( 'Mute', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => ['youtube','vimeo','dailymotion'],
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => ['youtube','vimeo'],
				],
			]
		);

		$this->add_control(
			'controls',
			[
				'label' => __( 'Player Controls', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'condition' => [
					'video_type' => ['youtube','dailymotion'],
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Controls Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'video_type' => [ 'vimeo', 'dailymotion' ],
				],
			]
		);

		$this->add_control(
			'modestbranding',
			[
				'label' => __( 'Modest Branding', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'video_type' => [ 'youtube' ],
					'controls' => 'yes',
				],
			]
		);

		$this->add_control(
			'showinfo',
			[
				'label' => __( 'Video Info', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'condition' => [
					'video_type' => [ 'youtube', 'dailymotion' ],
				],
			]
		);

		$this->add_control(
			'logo',
			[
				'label' => __( 'Logo', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => [ 'dailymotion' ],
				],
			]
		);

		$this->add_control(
			'rel',
			[
				'label' => __( 'Suggested Videos', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

		$this->add_control(
			'privacy',
			[
				'label' => __( 'Privacy Mode', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'larisdigital-wp' ),
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

		$this->add_control(
			'vimeo_title',
			[
				'label' => __( 'Intro Title', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'vimeo_portrait',
			[
				'label' => __( 'Intro Portrait', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'vimeo_byline',
			[
				'label' => __( 'Intro Byline', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'larisdigital-wp' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'youtube',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_style',
			[
				'label' => __( 'Video', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'container_width',
			[
				'label' => __( 'Container Max Width (px)', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 2000,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .tp-video-container' => 'max-width: {{SIZE}}{{UNIT}};margin:0 auto;',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$video_width = 560;
		$video_height = $this->get_video_height( $settings['aspect_ratio'], $video_width );

		$this->add_render_attribute( 'container', 'class', 'tp-video-container' );
		$this->add_render_attribute( 'wrapper', 'class', 'tp-video-wrapper' );

		if ( $settings['video_type'] == 'youtube' ) {

			$video_link = $settings['youtube_url'];

			if ( empty( $video_link ) )
				return;

			$embed_id = $this->get_yt_embed_id( $video_link );

			if ( empty( $embed_id ) )
				return;

			$params = [];

			$video_options = [
				'autoplay' => 'autoplay',
				'loop' => 'loop',
				'controls' => 'controls',
				'mute' => 'mute',
				'showinfo' => 'showinfo',
				'rel' => 'rel',
				'modestbranding' => 'modestbranding',
			];

			foreach ( $video_options as $option => $param_name ) {
				$value = ( 'yes' === $settings[ $option ] ) ? '1' : '0';
				$params[ $param_name ] = $value;
			}

			if ( 'yes' == $settings['loop'] ) {
				$params[ 'playlist' ] = $embed_id;
			}

			$params['wmode'] = 'opaque';

			if ( 'yes' == $settings['privacy'] ) {
				$video_src = add_query_arg( $params, 'https://www.youtube-nocookie.com/embed/'.$embed_id );
			}
			else {
				$video_src = add_query_arg( $params, 'https://www.youtube.com/embed/'.$embed_id );
			}

			$this->add_render_attribute( 'iframe', 'src', $video_src );
			$this->add_render_attribute( 'iframe', 'width', $video_width );
			$this->add_render_attribute( 'iframe', 'height', $video_height );
			$this->add_render_attribute( 'iframe', 'frameborder', '0' );
			$this->add_render_attribute( 'iframe', 'allowfullscreen', '1' );
		}
		elseif ( $settings['video_type'] == 'facebook' ) {

			$video_link = $settings['facebook_url'];

			if ( empty( $video_link ) )
				return;

			$params = [];

			$params['href'] = rawurlencode( $video_link );
			$params['width'] = $video_width;
			$params['height'] = $video_height;
			$params['show_text'] = 'false';
			$params['show_captions'] = 'false';

			$video_options = [
				'autoplay' => 'autoplay',
			];

			foreach ( $video_options as $option => $param_name ) {
				$value = ( 'yes' === $settings[ $option ] ) ? '1' : '0';
				$params[ $param_name ] = $value;
			}

			$video_src = add_query_arg( $params, 'https://www.facebook.com/v3.0/plugins/video.php' );

			$this->add_render_attribute( 'iframe', 'src', $video_src );
			$this->add_render_attribute( 'iframe', 'width', $video_width );
			$this->add_render_attribute( 'iframe', 'height', $video_height );
			$this->add_render_attribute( 'iframe', 'frameborder', '0' );
			$this->add_render_attribute( 'iframe', 'scrolling', 'no' );
			$this->add_render_attribute( 'iframe', 'allowTransparency', 'true' );
			$this->add_render_attribute( 'iframe', 'style', 'border:none;overflow:hidden' );
		}
		elseif ( $settings['video_type'] == 'vimeo' ) {

			$video_link = $settings['vimeo_url'];

			if ( empty( $video_link ) )
				return;

			$embed_id = $this->get_vimeo_embed_id( $video_link );

			if ( empty( $embed_id ) )
				return;

			$params = [];

			$video_options = [
				'autoplay' => 'autoplay',
				'loop' => 'loop',
				'mute' => 'muted',
				'vimeo_title' => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline' => 'byline',
			];

			foreach ( $video_options as $option => $param_name ) {
				$value = ( 'yes' === $settings[ $option ] ) ? '1' : '0';
				$params[ $param_name ] = $value;
			}

			$params['color'] = str_replace( '#', '', $settings['color'] );

			$params['autopause'] = '0';

			$video_src = add_query_arg( $params, 'https://player.vimeo.com/video/'.$embed_id );

			$this->add_render_attribute( 'iframe', 'src', $video_src );
			$this->add_render_attribute( 'iframe', 'width', $video_width );
			$this->add_render_attribute( 'iframe', 'height', $video_height );
			$this->add_render_attribute( 'iframe', 'frameborder', '0' );
			$this->add_render_attribute( 'iframe', 'allowfullscreen', '1' );
		}
		elseif ( $settings['video_type'] == 'dailymotion' ) {

			$video_link = $settings['dailymotion_url'];

			if ( empty( $video_link ) )
				return;

			$embed_id = $this->get_dailymotion_embed_id( $video_link );

			if ( empty( $embed_id ) )
				return;

			$params = [];

			$video_options = [
				'autoplay' => 'autoplay',
				'controls' => 'controls',
				'mute' => 'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo' => 'ui-logo',
			];

			foreach ( $video_options as $option => $param_name ) {
				$value = ( 'yes' === $settings[ $option ] ) ? '1' : '0';
				$params[ $param_name ] = $value;
			}

			$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

			$params['endscreen-enable'] = '0';

			$video_src = add_query_arg( $params, 'https://dailymotion.com/embed/video/'.$embed_id );

			$this->add_render_attribute( 'iframe', 'src', $video_src );
			$this->add_render_attribute( 'iframe', 'width', $video_width );
			$this->add_render_attribute( 'iframe', 'height', $video_height );
			$this->add_render_attribute( 'iframe', 'frameborder', '0' );
			$this->add_render_attribute( 'iframe', 'allowfullscreen', '1' );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<iframe <?php echo $this->get_render_attribute_string( 'iframe' ); ?>></iframe>
			</div>
		</div>
		<?php 
	}

	public function get_yt_embed_id( $url ) {
		$pattern = "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#";
		$result = preg_match($pattern, $url, $matches);
		if ( false !== $result && isset( $matches[0] ) ) {
			return $matches[0];
		}
		return false;
	}

	// https://github.com/lingtalfi/video-ids-and-thumbnails
	public function get_vimeo_embed_id( $url ) {
		$pattern = '#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#';
		$result = preg_match($pattern, $url, $matches);
		if ( false !== $result && isset( $matches[1] ) ) {
			return $matches[1];
		}
		return false;
	}

	// https://github.com/lingtalfi/video-ids-and-thumbnails
	public function get_dailymotion_embed_id( $url ) {
		$pattern = '!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!';
		$result = preg_match($pattern, $url, $matches);
		if ( false !== $result ) {
			if ( isset( $matches[6] ) ) {
				return $matches[6];
			}
			if ( isset( $matches[4] ) ) {
				return $matches[4];
			}
			if ( isset( $matches[2] ) ) {
				return $matches[2];
			}
		}
		return false;
	}

	public function get_video_height( $aspect_ratio = 'ar169', $video_width = 560 ) {
		if ( $video_width < 100 ) {
			$video_width = 560;
		}
		if ( ! in_array( $aspect_ratio, [ 'ar169', 'ar43', 'ar32', 'ar11', 'ar23', 'ar34', 'ar916' ] ) ) {
			$aspect_ratio = 'ar169';
		}
		if ( $aspect_ratio == 'ar169' ) {
			$video_height = absint( $video_width * 9 / 16 ); 
		}
		elseif ( $aspect_ratio == 'ar43' ) {
			$video_height = absint( $video_width * 3 / 4 ); 
		}
		elseif ( $aspect_ratio == 'ar32' ) {
			$video_height = absint( $video_width * 2 / 3 ); 
		}
		elseif ( $aspect_ratio == 'ar11' ) {
			$video_height = absint( $video_width ); 
		}
		elseif ( $aspect_ratio == 'ar23' ) {
			$video_height = absint( $video_width * 3 / 2 ); 
		}
		elseif ( $aspect_ratio == 'ar34' ) {
			$video_height = absint( $video_width * 4 / 3 ); 
		}
		elseif ( $aspect_ratio == 'ar916' ) {
			$video_height = absint( $video_width * 16 / 9 ); 
		}
		return $video_height;
	}
}
