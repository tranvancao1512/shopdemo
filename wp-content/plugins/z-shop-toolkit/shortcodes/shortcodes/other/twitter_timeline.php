<?php


class toolkit_basr_shortcode_twitter_timeline extends toolkit_basr_shortcode {

	// shortcode name

	public $shortcode = 'twitter_timeline';

	public function vc_map_shortcode() {
		vc_map( array(
				'base' 				=> $this->base,
				'name' 				=> esc_html__( 'Toolkit Twitter Timeline', 'basr-core' ),
				'class' 			=> '',
				'category' 			=> $this->cat,
				'icon' 				=> $this->icon,
				'params' 			=> array(
					array(
						'param_name'       => $this->base . '_id',
						'heading'          => esc_html__( 'ID', 'basr-core' ),
						'type'             => 'textfield',
						'value'            =>  0,
						'edit_field_class' => 'hidden',
					),
					array(
						'param_name'  => 'oauth_access_token',
						'heading'     => esc_html__( 'OAUTH Access Token', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'oauth_access_token_secret',
						'heading'     => esc_html__( 'OAUTH Access Token Secret', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'consumer_key',
						'heading'     => esc_html__( 'Consumer Key', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'consumer_secret',
						'heading'     => esc_html__( 'Consumer Secret', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'username',
						'heading'     => esc_html__( 'Twitter Username', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'count',
						'heading'     => esc_html__( 'Tweets count', 'basr-core' ),
						'type'        => 'textfield',
					),
					toolkit_basr_vcf_class(),
					toolkit_basr_vcf_animate(0),
					toolkit_basr_vcf_animate(1),
					toolkit_basr_vcf_animate(2),

					// More fields here

				),
			)
		);
	}

	// Render html

	public function enqueue_script( $extra = array() ) {
		parent::enqueue_script();
	}

	public function generate_html( $atts, $content = null ) {

		require_once TOOLKIT_BASR_TOOLKIT_PATH . '/include/TwitterAPIExchange.php';

		$sc_atts =  array(
			'oauth_access_token' 		=> '',
			'oauth_access_token_secret' 		=> '',
			'consumer_key'		=> '',
			'consumer_secret'	=> '',
			'username'	=> '',
			'count'	=> '4',
			$this->base . '_id' 				=> ''				,
			'classes'							=> ''				,
			'anm'								=> '0'				,
			'anm_name'							=> 'fadeIn'				,
			'anm_delay'							=> '1000'			,
		);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue

		$this->enqueue_script(${$this->base . '_id'});

		// get id

		$id = ${$this->base . '_id'} ;

		// get class


		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
			'oauth_access_token' => $oauth_access_token,
			'oauth_access_token_secret' => $oauth_access_token_secret,
			'consumer_key' => $consumer_key,
			'consumer_secret' => $consumer_secret,
		);
		$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
		$requestMethod = "GET";
		$getfield = "?screen_name=$username&count=$count";
		$twitter = new TwitterAPIExchange($settings);
		$string = json_decode($twitter->setGetfield($getfield)
		                              ->buildOauth($url, $requestMethod)
		                              ->performRequest(),$assoc = TRUE);
		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';

		// content
		ob_start(); ?>
		<?php
		if( isset($string["errors"]) && $string["errors"][0]["message"] != "") {
			echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string["errors"][0]["message"]."</em></p>";
		} else {
			foreach($string as $items) : ?>
				<div class="tweet">
					<div class="screen-name">
						<i class="fa fa-twitter"></i>
						<?php echo '<h3>' . $items['user']['screen_name'] . '</h3>' ; ?>
					</div>
					<p class="tweet-content">
						<?php 
							echo preg_replace( '/(http[^\s]+)/', '<a href="$1">$1</a>', $items['text'] );
						?>
					</p>
					<time datetime="<?php echo $items['created_at']; ?>"><?php echo human_time_diff(strtotime($items['created_at'])); ?> ago</time>
				</div>
			<?php endforeach;
			?>
			<?php
		}
		$output .= ob_get_clean();

		$output .= '</div>';

		// filter

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		return $css;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {
	class WPBakeryShortCode_Lucy_twitter_timeline extends WPBakeryShortCode {
	}
}
