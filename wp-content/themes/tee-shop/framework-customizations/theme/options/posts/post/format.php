<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(

	// example logic

	// 'attr' => array(
	// 	'class'				=> 'basr-rever-logic',
	// 	'data-logic-item' 	=> 'post-formats-select',
	// 	'data-logic-value'  => 'post-format-video'

	// 'class'				=> 'basr-logic',
	// 'data-logic-item' 	=> 'video_section',
	// 'data-logic-value'   => 'switch-right'

	'video_section' => array(
		'type'  => 'html-full',
		'label' => false,
		'html'  => '<strong>Video Format</strong>',
		'attr' => array(
			'style' => 'margin-top: -24px; margin-left: -27px; margin-right: -27px; margin-bottom: -21px; padding: 15px 27px 15px; background: #555; color: #fff;',
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-video'
		),
	),
	'post_format_video' => array(
		'label' => false,
		'type'  => 'multi-picker',
		'value'	 => array(
			'_source'	=> 'link',
		),
		'attr' => array(
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-video'
		),
		'picker'	=> array(
			'_source' => array(
				'label'	 => esc_html__('Video Source', 'origin'),
				'type'		 => 'select',
				'value'		=> 'link',
				'choices' => array(
					'link' => esc_html__('Video Link', 'origin'),
					'embeded' => esc_html__('Video Embed Code', 'origin'),
					'local' => esc_html__('Upload Local File', 'origin'),
				),
			)
		),
		'choices'   => array(
			'link'  => array(
				'video_url' => array(
					'type' => 'text',
					'label' => esc_html__('Video URL', 'origin'),
					'desc' => esc_html__('You can choose Youtube or Vimeo link (eg: https://www.youtube.com/watch?v=uxHXATYpt2w)', 'origin'),
				),
				'video_thumb' => array(
					'type'  => 'switch',
					'label' => esc_html__('Use post thumbnail as video thumbnail', 'origin'),
					'value'	=> true,
					'left-choice' => array(
				        'value' => false,
				        'label' => esc_html__('No', 'origin'),
				    ),
				    'right-choice' => array(
				        'value' => true,
				        'label' => esc_html__('Yes', 'origin'),
				    ),
				),
			),
			'embeded' => array(
				'video_embed_code' => array(
					'type' => 'textarea',
					'label' => esc_html__('Video embed code', 'origin'),
				),
			),
			'local' => array(
				'video_local' => array(
					'type' => 'upload',
					'label' => esc_html__('Upload video file', 'origin'),
					'desc' => esc_html__('Support .mp4 file only', 'origin'),
					'files_ext' => array( 'mp4' ),
				),
			),
		),
		'show_borders' => false,
	),
	'audio_section' => array(
		'type'  => 'html-full',
		'label' => false,
		'attr' => array(
			'style' => 'margin-top: -24px; margin-left: -27px; margin-right: -27px; margin-bottom: -21px; padding: 15px 27px 15px; background: #555; color: #fff;',
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-audio'
		),
		'html'  => '<strong>Audio Format</strong>',
	),
	'post_format_audio' => array(
		'label' => false,
		'type' => 'multi-picker',
		'value'	 => array(
			'_source'	=> 'soundcloud',
		),
		'attr' => array(
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-audio'
		),
		'picker'	=> array(
			'_source' => array(
				'label'	 => esc_html__('Audio Source', 'origin'),
				'type'		 => 'select',
				'value'		=> 'link',
				'choices' => array(
					'soundcloud' => esc_html__('Soundcloud Link', 'origin'),
					'local' => esc_html__('Upload Local File', 'origin'),
				),
			)
		),
		'choices'   => array(
			'soundcloud'  => array(
				'soundcloud_url' => array(
					'type' => 'text',
					'label' => esc_html__('SoundCloud URL', 'origin'),
				),
			),
			'local' => array(
				'audio_local' => array(
					'type' => 'upload',
					'label' => esc_html__('Upload audio file', 'origin'),
					'desc' => esc_html__('Support .mp3 file only', 'origin'),
					'files_ext' => array( 'mp3' ),
				),
			),
		),
		'show_borders' => false,
	),
	'quote_section' => array(
		'type'  => 'html-full',
		'label' => false,
		'attr' => array(
			'style' => 'margin-top: -24px; margin-left: -27px; margin-right: -27px; margin-bottom: -21px; padding: 15px 27px 15px; background: #555; color: #fff;',
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-quote'
		),
		'html'  => '<strong>Quote Format</strong>',
	),
	'post_format_quote' => array(
		'type' => 'multi',
		'label' => false,
		'attr' => array(
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-quote'
		),
		'inner-options' => array(
			'_author' => array(
				'type' => 'text',
				'label' => esc_html__('Quote Author', 'origin'),
			),
			'_author_URL' => array(
				'type' => 'text',
				'label' => esc_html__('Quote Author URL', 'origin'),
			),
			'_content' => array(
				'type' => 'textarea',
				'label' => esc_html__('Quote Content', 'origin'),
			),
		),
	),
	'gallery_section' => array(
		'type'  => 'html-full',
		'label' => false,
		'attr' => array(
			'style' => 'margin-top: -24px; margin-left: -27px; margin-right: -27px; margin-bottom: -21px; padding: 15px 27px 15px; background: #555; color: #fff;',
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-gallery'
		),
		'html'  => '<strong>Gallery Format</strong>',
	),
	'post_format_gallery' => array(
		'type' => 'multi',
		'label' => false,
		'attr' => array(
			'class'				=> 'basr-rever-logic',
			'data-logic-item' 	=> 'post-formats-select',
			'data-logic-value'  => 'post-format-gallery'
		),
		'inner-options' => array(
			'_images' => array(
				'type' => 'multi-upload',
				'label' => esc_html__('Upload Gallery', 'origin'),
				'images_only' => true,
			),
			'_fade' => array(
				'type'  => 'switch',
				'value' => 'true',
				'label' => esc_html__('Fade animation', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Yes', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('No', 'origin'),
				),
			),
			'_autoplay' => array(
				'type'  => 'switch',
				'value' => 'true',
				'label' => esc_html__('Gallery Autoplay?', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Yes', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('No', 'origin'),
				),
			),
			'_duration' => array(
				'type' => 'number',
				'label' => esc_html__('Auto Play speed', 'origin'),
				'value' => '5000',
				'desc' => esc_html__('Unit: milisecond(ms).', 'origin'),
				'attr' => array(
					'min' => 1000,
				),
			),
			'_speed' => array(
				'type'  => 'number',
				'label' => esc_html__('Gallery Speed', 'origin'),
				'value' => '300',
				'desc'  => esc_html__('Unit: milisecond(ms).', 'origin'),
				'attr'  => array(
					'min' => 300,
				),
			),
			'_pagination' => array(
				'type'  => 'switch',
				'value' => 'true',
				'label' => esc_html__('Gallery Pagination?', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'_navigation' => array(
				'type'  => 'switch',
				'value' => 'true',
				'label' => esc_html__('Gallery Navigation?', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
		),
	),
);
