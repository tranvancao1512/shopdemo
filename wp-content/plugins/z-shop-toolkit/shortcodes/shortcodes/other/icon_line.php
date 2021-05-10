<?php


class toolkit_basr_shortcode_icon_line extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'icon_line';

	// this->base = $prefix + $shortcode;

	public function register_script() {

	}

	// Enqueue script, style 

	public function enqueue_script( $extra = array() ) {
		if ( is_singular() ) {

			global $post;

			if ( has_shortcode( $post->post_content, "{$this->base}" ) ) {
				parent::enqueue_script();
			}
		}

	}

	// map shortcode to vc

	public function vc_map_shortcode() {
		vc_map( array(
				'base'     => $this->base,
				'name'     => esc_html__( 'Icon item', 'basr-core' ),
				'class'    => '',
				'category' => $this->cat,
				'icon'     => $this->icon,
				'as_child' => array(
					'only' => $this->prefix . 'icons_line',
				),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Title', 'basr-core' ),
						'param_name' => 'title',
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Subtitle', 'basr-core' ),
						'param_name' => 'subtitle',
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Give it a link', 'basr-core' ),
						'param_name' => 'url',
					),
					array(
						'param_name' => 'icon_type',
						'heading'    => esc_html__( 'Icon Type', 'basr-core' ),
						'type'       => 'dropdown',
						'holder'     => 'div',
						'value'      => array(
							esc_html__( 'PNG Image', 'basr-core' ) => 'img',
							esc_html__( 'Icon Font', 'basr-core' ) => 'font',
						),
					),
					array(
						'type'        => 'attach_image',
						'heading'     => __( 'Icon image', 'basr-core' ),
						'description' => __( 'Use PNG image for best result', 'basr-core' ),
						'param_name'  => 'img_icon',
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => array( 'img' ),
						),
					),
					array(
						'type'        => 'attach_image',
						'heading'     => __( 'Icon Hover image', 'basr-core' ),
						'description' => __( 'Use PNG image for best result', 'basr-core' ),
						'param_name'  => 'img_icon_hover',
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => array( 'img' ),
						),
					),
					array(
						'type'        => 'iconpicker',
						'heading'     => __( 'Icon', 'basr-core' ),
						'param_name'  => 'font_icon',
						'value'       => 'fa fa-adjust', // default value to backend editor admin_label
						'settings'    => array(
							'emptyIcon'    => false,
							// default true, display an "EMPTY" icon?
							'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
						),
						'description' => __( 'Select icon from library.', 'basr-core' ),
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => array( 'font' ),
						),
					),
					array(
						'param_name' => 'icon_size',
						'heading'    => esc_html__( 'Custom Icon size', 'basr-core' ),
						'type'       => 'textfield',
					),
				array(
					'param_name'       => $this->base . '_id',
					'heading'          => esc_html__( 'ID', 'basr-core' ),
					'type'             => 'textfield',
					'value'            =>  0,
					'edit_field_class' => 'hidden',
				),
					toolkit_basr_vcf_class(),
					toolkit_basr_vcf_animate( 0 ),
					toolkit_basr_vcf_animate( 1 ),
					toolkit_basr_vcf_animate( 2 ),
				),
			)
		);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {
		$this->enqueue_script();

		extract( shortcode_atts( array(
			'title'             => '',
			'subtitle'          => '',
			'url'               => '#',
			'icon_type'         => 'img',
			'img_icon'          => '',
			'img_icon_hover'    => '',
			'font_icon'         => 'fa fa-adjust',
			$this->base . '_id' => '',
			'classes'           => '',
			'anm'               => '',
			'anm_name'          => '',
			'anm_delay'         => '',
		), $atts ) );

		// get id 

		$id = ${$this->base . '_id'};

		// get class

		$classes .= $this->get_class(); // pass id setting if need vc custome css class,

		// set up shortcode here
		$icon = '';
		if ( $icon_type === 'font' ) {
			$icon = '<i class="' . $font_icon . '"></i>';
		}

		// Start out put

		$output = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';

		ob_start();
		?>

		<?php if ( $url === '#' ): ?>
			<div class="insider">
			<span class="icon">
				<?php echo $icon; ?>
			</span>
				<h3 class="title"><?php echo $title; ?></h3>
				<p class="subtitle"><?php echo $subtitle; ?></p>
			</div>
		<?php else: ?>
			<a class="insider" href="<?php echo $url; ?>">
			<span class="icon">
				<?php echo $icon; ?>
			</span>
				<h3 class="title"><?php echo $title; ?></h3>
				<p class="subtitle"><?php echo $subtitle; ?></p>
			</a>
		<?php endif; ?>

		<?php
		$output .= ob_get_clean();

		$output .= '</div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	public function generate_shortcode_css( $atts ) {
		extract( shortcode_atts( array(
			$this->base . '_id'  => '',
			'icon_size'            => '',
			'icon_type' => 'img',
			'img_icon' => '',
			'img_icon_hover' => '',
			// atts here

		), $atts ) );

		$id = '#' . ${$this->base . '_id'};

		$css = $id . ' .icon {';

		if( $icon_size ) {
			$css .= 'font-size:' . $icon_size . 'px;';
			$css .= 'background-size:' . $icon_size . 'px;';
		}
		if( $icon_type === 'img' && $img_icon ) {
			$css .= 'background-image: url('. basr_get_image_url($img_icon) .');';
		}
		$css .= '}';

		$css .= $id . ' > div:hover .icon {';
		if( $icon_type === 'img' && $img_icon_hover ) {
			$css .= 'background-image: url('. basr_get_image_url($img_icon_hover) .');';
		}
		$css .= '}';


		return $css;
	}

}

if ( class_exists( 'VC_Manager' ) && is_admin() ) {

	class WPBakeryShortCode_lucy_icon_line extends WPBakeryShortCode {
	}

}
