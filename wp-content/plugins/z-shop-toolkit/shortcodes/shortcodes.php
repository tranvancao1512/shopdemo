<?php
/*
/*
 *  Register listing 
*/

function toolkit_basr_listing_shortcode () {

	return array(
		// common shortcodes

		'heading'			=>	array(
									'slug'		=> 'heading',
									'icon'		=> 'fa fa-header',
									'type'      => 'common',
								),

		'empty_space'		=> array(
									'slug'		=> 'empty_space',
									'icon'		=> 'fa fa-arrows-v',
									'type'      => 'common',
								),
		'map'				=> 	array(
									'slug'		=> 'map',
									'icon'		=> 'fa fa-map-marker',
									'type'      => 'common',
								),
		'social_info'		=> 	array(
									'slug'		=> 'social_info',
									'icon'		=> 'fa fa-share-alt',
									'type'      => 'common',
								),
		'isotope'			=>	array(
									'slug'		=> 'isotope',
									'icon'		=> 'ion-android-apps',
									'type'      => 'common',
								),
		'blogs_listing'		=> 	array(
									'slug'		=> 'blogs_listing',
									'icon'		=> '',
									'type'      => 'common',
								),
		'service'			=> 	array(
									'slug'		=> 'service',
									'icon'		=> 'ion-code-working',
									'type'      => 'common',
								),
		'service_item'		=> 	array(
									'slug'		=> 'service_item',
									'icon'		=> 'ion-code-working',
									'type'      => 'common',
								),
		'background_icon'		=> 	array(
									'slug'		=> 'background_icon',
									'icon'		=> 'ion-code-working',
									'type'      => 'common',
								),
		'slick_slider'		=> 	array(
									'slug'		=> 'slick_slider',
									'icon'		=> 'ion-code-working',
									'type'      => 'common',
								),
		'page_nav'		=> 	array(
									'slug'		=> 'page_nav',
									'icon'		=> 'ion-ios-list-outline',
									'type'      => 'common',
								),
		'page_nav_item'		=> 	array(
									'slug'		=> 'page_nav_item',
									'icon'		=> 'ion-ios-information-empty',
									'type'      => 'common',
								),
		'slick_item'		=> 	array(
									'slug'		=> 'slick_item',
									'icon'		=> 'ion-ios-albums-outline',
									'type'      => 'common',
								),
		'icon_box'			=> 	array(
									'slug'		=> 'icon_box',
									'icon'		=> 'ion-ios-albums-outline',
									'type'      => 'common',
								),
		'member'			=> 	array(
									'slug'		=> 'member',
									'icon'		=> 'ion-ios-albums-outline',
									'type'      => 'common',
								),
		'portfolio_listing'	=> array(
									'slug'		=> 'portfolio_listing',
									'icon'		=> 'ion-android-apps',
									'type'      => 'portfolio',
								),
		'button'				=>	array(
									'slug'		=> 'button',
									'icon'		=> 'fa fa-stop',
									'type'      => 'other',
								),
		'animator'				=>	array(
										'slug'		=> 'animator',
										'icon'		=> 'ion-ios-pulse',
										'type'      => 'other',
									),
		'tee_ct'			=> 	array(
									'slug'		=> 'tee_ct',
									'icon'		=> 'ion-ios-albums-outline',
									'type'      => 'common',
								),
		'banner'			=> 	array(
									'slug'		=> 'banner',
									'icon'		=> 'ion-image',
									'type'      => 'other',
								),
		'lightbox_video'	=> 	array(
									'slug'		=> 'lightbox_video',
									'icon'		=> 'ion-ios-film-outline',
									'type'      => 'other',
								),
		'twitter_timeline'	=>	array(
									'slug'		=> 'twitter_timeline',
									'icon'		=> 'ion-social-twitter',
									'type'      => 'other',
								),
		'testimonial'		=>	array(
									'slug'		=> 'testimonial',
									'icon'		=> 'ion-android-people',
									'type'      => 'other',
								),
		'tee_shop_wc_cat' =>	array(
									'slug'		=> 'tee_shop_wc_cat',
									'icon'		=> 'ion-android-people',
									'type'      => 'common',
								),
		'tee_shop_wc_collection' =>	array(
									'slug'		=> 'tee_shop_wc_collection',
									'icon'		=> 'ion-android-people',
									'type'      => 'common',
								),
		'product_template_title' =>	array(
									'slug'		=> 'product_template_title',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_content' =>	array(
									'slug'		=> 'product_template_content',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_content_m' =>	array(
									'slug'		=> 'product_template_content_m',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_tag' =>	array(
									'slug'		=> 'product_template_tag',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_images' =>	array(
									'slug'		=> 'product_template_images',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_images_m' =>	array(
									'slug'		=> 'product_template_images_m',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_seo' =>	array(
									'slug'		=> 'product_template_seo',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_variant_m' =>	array(
									'slug'		=> 'product_template_variant_m',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_variant' =>	array(
									'slug'		=> 'product_template_variant',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_variant_item' =>	array(
									'slug'		=> 'product_template_variant_item',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
		'product_template_variant_item_2' =>	array(
									'slug'		=> 'product_template_variant_item_2',
									'icon'		=> 'ion-android-people',
									'type'      => 'template',
								),
	);

}

