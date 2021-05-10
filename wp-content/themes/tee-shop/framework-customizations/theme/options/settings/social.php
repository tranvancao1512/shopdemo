<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'tab_social_info' => array(
		'title'   => esc_html__( 'Your social', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'social_target' => array(
				'type' => 'select',
				'label' => esc_html__('Target', 'origin'),
				'value' => 'new_tab',
				'choices' => array(
					'new_tab' => esc_html__('New tab', 'origin'),
					'same_tab' => esc_html__('Same tab', 'origin'),
				),
			),
			'social_twitter_username' => array(
				'type' => 'text',
				'label' => esc_html__('Twitter Username', 'origin'),
				'desc' => esc_html__('Twitter username used for tweet share buttons.', 'origin'),
			),
			'social_links' => array(
				'type' => 'multi',
				'attr' => array(
					'class' => 'fw-option-type-multi-show-borders'
				),
				'label' => false,
				'inner-options' => array(
					'_facebook' => array(
						'type' => 'text',
						'label' => esc_html__('Facebook', 'origin'),
					),
					'_twitter' => array(
						'type' => 'text',
						'label' => esc_html__('Twitter', 'origin'),
					),
					'_google-plus' => array(
						'type' => 'text',
						'label' => esc_html__('Google+', 'origin'),
					),
					'_linkedin' => array(
						'type' => 'text',
						'label' => esc_html__('LinkedIn', 'origin'),
					),
					'_tumblr' => array(
						'type' => 'text',
						'label' => esc_html__('Tumblr', 'origin'),
					),
					'_pinterest' => array(
						'type' => 'text',
						'label' => esc_html__('Pinterest', 'origin'),
					),
					'_youtube' => array(
						'type' => 'text',
						'label' => esc_html__('YouTube', 'origin'),
					),
					'_skype' => array(
						'type' => 'text',
						'label' => esc_html__('Skype', 'origin'),
					),
					'_instagram' => array(
						'type' => 'text',
						'label' => esc_html__('Instagram', 'origin'),
					),
					'_delicious' => array(
						'type' => 'text',
						'label' => esc_html__('Delicious', 'origin'),
					),
					'_reddit' => array(
						'type' => 'text',
						'label' => esc_html__('Reddit', 'origin'),
					),
					'_stumbleupon' => array(
						'type' => 'text',
						'label' => esc_html__('StumbleUpon', 'origin'),
					),
					'_wordpress' => array(
						'type' => 'text',
						'label' => esc_html__('WordPress', 'origin'),
					),
					'_joomla' => array(
						'type' => 'text',
						'label' => esc_html__('Joomla', 'origin'),
					),
					'_blogger' => array(
						'type' => 'text',
						'label' => esc_html__('Blogger', 'origin'),
					),
					'_vimeo' => array(
						'type' => 'text',
						'label' => esc_html__('Vimeo', 'origin'),
					),
					'_yahoo' => array(
						'type' => 'text',
						'label' => esc_html__('Yahoo!', 'origin'),
					),
					'_flickr' => array(
						'type' => 'text',
						'label' => esc_html__('Flickr', 'origin'),
					),
					'_picasa' => array(
						'type' => 'text',
						'label' => esc_html__('Picasa', 'origin'),
					),
					'_deviantart' => array(
						'type' => 'text',
						'label' => esc_html__('DeviantArt', 'origin'),
					),
					'_github' => array(
						'type' => 'text',
						'label' => esc_html__('GitHub', 'origin'),
					),
					'_stackoverflow' => array(
						'type' => 'text',
						'label' => esc_html__('StackOverFlow', 'origin'),
					),
					'_xing' => array(
						'type' => 'text',
						'label' => esc_html__('Xing', 'origin'),
					),
					'_flattr' => array(
						'type' => 'text',
						'label' => esc_html__('Flattr', 'origin'),
					),
					'_foursquare' => array(
						'type' => 'text',
						'label' => esc_html__('Foursquare', 'origin'),
					),
					'_paypal' => array(
						'type' => 'text',
						'label' => esc_html__('Paypal', 'origin'),
					),
					'_yelp' => array(
						'type' => 'text',
						'label' => esc_html__('Yelp', 'origin'),
					),
					'_soundcloud' => array(
						'type' => 'text',
						'label' => esc_html__('SoundCloud', 'origin'),
					),
					'_lastfm' => array(
						'type' => 'text',
						'label' => esc_html__('Last.fm', 'origin'),
					),
					'_lanyrd' => array(
						'type' => 'text',
						'label' => esc_html__('Lanyrd', 'origin'),
					),
					'_dribbble' => array(
						'type' => 'text',
						'label' => esc_html__('Dribbble', 'origin'),
					),
					'_forrst' => array(
						'type' => 'text',
						'label' => esc_html__('Forrst', 'origin'),
					),
					'_steam' => array(
						'type' => 'text',
						'label' => esc_html__('Steam', 'origin'),
					),
					'_behance' => array(
						'type' => 'text',
						'label' => esc_html__('Behance', 'origin'),
					),
					'_mixi' => array(
						'type' => 'text',
						'label' => esc_html__('Mixi', 'origin'),
					),
					'_weibo' => array(
						'type' => 'text',
						'label' => esc_html__('Weibo', 'origin'),
					),
					'_renren' => array(
						'type' => 'text',
						'label' => esc_html__('Renren', 'origin'),
					),
					'_evernote' => array(
						'type' => 'text',
						'label' => esc_html__('Evernote', 'origin'),
					),
					'_dropbox' => array(
						'type' => 'text',
						'label' => esc_html__('Dropbox', 'origin'),
					),
					'_bitbucket' => array(
						'type' => 'text',
						'label' => esc_html__('Bitbucket', 'origin'),
					),
					'_trello' => array(
						'type' => 'text',
						'label' => esc_html__('Trello', 'origin'),
					),
					'_vk' => array(
						'type' => 'text',
						'label' => esc_html__('VKontakte', 'origin'),
					),
					'_home' => array(
						'type' => 'text',
						'label' => esc_html__('Homepage', 'origin'),
					),
					'_email' => array(
						'type' => 'text',
						'label' => esc_html__('Email', 'origin'),
					),
					'_rss' => array(
						'type' => 'text',
						'label' => esc_html__('RSS', 'origin'),
					),
				),
			),
		),
	),
);

