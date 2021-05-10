<?php


class toolkit_basr_shortcode_button extends toolkit_basr_shortcode {

	// shortcode name

	public $shortcode = 'button';

	public function vc_map_shortcode() {
		vc_map( array(
				'base' 				=> $this->base,
				'name' 				=> esc_html__( 'Toolkit Button', 'basr-core' ),
				'class' 			=> '',
				'category' 			=> $this->cat,
				'icon' 				=> $this->icon,
				'params' 			=> array (

					array(
						'param_name'       => $this->base . '_id',
						'heading'          => esc_html__( 'ID', 'basr-core' ),
						'type'             => 'textfield',
						'value'            =>  0,
						'edit_field_class' => 'hidden',
					),
					array(
						'param_name'  => 'btn_text',
						'heading'     => esc_html__( 'Button Text', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'btn_link',
						'heading'     => esc_html__( 'Button Link', 'basr-core' ),
						'type'        => 'textfield',
					),
					array(
						'param_name'  => 'btn_link_blank',
						'heading'     => esc_html__( 'Open Link in new tab?', 'basr-core' ),
						'type'        => 'checkbox',
						'value'        => array(
							'' => true,
						),
						'dependency' => array(
							'element' => 'btn_link',
							'not_empty' => true,
						),
					),
					array(
						'param_name'  => 'fontsize',
						'heading'     => esc_html__( 'Font size', 'basr-core' ),
						'type'        => 'textfield',
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
					),
					array(
						'param_name'  => 'text_transform',
						'heading'     => esc_html__( 'Text transform', 'basr-core' ),
						'type'        => 'dropdown',
						'holder'      => 'div',
						'std'         => 'uppercase',
						'value' 	  => array(
							esc_html__( 'Uppercase', 'basr-core' ) 		=> 'uppercase',
							esc_html__( 'Lowercase', 'basr-core' ) 		=> 'lowercase',
							esc_html__( 'None', 'basr-core' ) 			=> 'none',
						),
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
					),
					array(
			            'type' => 'css_editor',
			            'heading' => __( 'Css', 'basr-core' ),
			            'param_name' => 'css',
			            'group' => __( 'Design options', 'basr-core' ),
			        ),
					array(
						'param_name'  => 'align',
						'heading'     => esc_html__( 'Align', 'basr-core' ),
						'type'        => 'dropdown',
						'holder'      => 'div',
						'std'         => 'left',
						'value' 	  => array(
							esc_html__( 'inline', 'basr-core' ) 		=> 'inline-block',
							esc_html__( 'Left', 'basr-core' ) 		=> 'left',
							esc_html__( 'Center', 'basr-core' ) 		=> 'center',
							esc_html__( 'Right', 'basr-core' ) 		=> 'right',
						),
					),

					array(
						'param_name'  			 => 'color_text',
						'heading'     			 => esc_html__( 'Button Text Color', 'basr-core' ),
						'type'       			 => 'colorpicker',
						'holder'     			 => 'div',
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
						'value'         		 => '',
						'group'		  => esc_html__( 'Change Color', 'basr-core' )
					),
					array(
						'param_name'  => 'color_bg',
						'heading'     => esc_html__( 'Background Color', 'basr-core' ),
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'group'		  => esc_html__( 'Change Color', 'basr-core' ),
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
					),
					array(
						'param_name'  => 'color_hover_text',
						'heading'     => esc_html__( 'Button Text Hover', 'basr-core' ),
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'value'       => '',
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
						'group'		  => esc_html__( 'Change Color', 'basr-core' )
					),
					array(
						'param_name'  => 'color_hover_bg',
						'heading'     => esc_html__( 'Background Hover', 'basr-core' ),
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'value'         => '',
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
						'group'		  => esc_html__( 'Change Color', 'basr-core' )
					),
					array(
						'param_name'  => 'color_hover_border',
						'heading'     => esc_html__( 'Border Hover', 'basr-core' ),
						'type'        => 'colorpicker',
						'holder'      => 'div',
						'value'         => '',
						'edit_field_class'       => 'vc_col-xs-6 vc_col-md-4',
						'group'		  => esc_html__( 'Change Color', 'basr-core' )
					),
					toolkit_basr_vcf_class(),
					toolkit_basr_vcf_animate(0),
					toolkit_basr_vcf_animate(1),
					toolkit_basr_vcf_animate(2),
				),
			)
		);
	}

	// Render html

	public function enqueue_script( $extra = array() ) {
		parent::enqueue_script();
	}

	public function generate_html( $atts, $content = null ) {

		$sc_atts =  array(
			$this->base . '_id' 				=> ''				,
			'style' 							=> 'outline'		,
			'css'								=> ''				,
			'align'								=> ''				,
			'btn_text'                         	=> ''               ,
			'btn_link'                          => ''               ,
			'btn_link_blank'                    => ''               ,
			'classes'							=> ''				,
			'anm'								=> '0'				,
			'anm_name'							=> 'fadeIn'				,
			'anm_delay'							=> '1000'			,
		);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue

		$this->enqueue_script(${$this->base . '_id'});

		// get id

		$id = (empty(${$this->base . '_id'})) ? 'basr-' . wp_create_nonce() : ${$this->base . '_id'};

		// get class
		$vc_css_class = vc_shortcode_custom_css_class( $css, ' ' );

		$style .= $vc_css_class;

		$classes .= $this->get_class( '', $align );

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . ' >';

		// content
		ob_start(); ?>

		<?php if( $btn_link ) : ?>
			<a href="<?php echo esc_url($btn_link); ?>" class="button <?php echo esc_attr($style); ?>" <?php echo $btn_link_blank ? 'target="_blank"' : ''; ?>>
				<?php echo esc_html($btn_text); ?>
			</a>
		<?php else: ?>
			<button class="button <?php echo esc_attr($style); ?>">
				<?php echo esc_html($btn_text); ?>
			</button>
		<?php endif; ?>

		<?php $output .= ob_get_clean();

		$output .= '</div>';

		// filter

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'style' 					=> 'outline'	,
			'text_transform'			=> ''	,
			'align' 					=> 'left'		,
			'fontsize' 					=> ''			,
			'btn_text'                  => ''           ,
			'color_text'                => ''           ,
			'color_bg'                  => ''    		,
			'color_border'              => ''           ,
			'color_hover_text'          => ''           ,
			'color_hover_bg'            => ''        	,
			'color_hover_border'        => ''        	,
			'classes'					=> ''			,
		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };
		$button = $id . ' .button';
		$css = '';

		$css .= sprintf(
			'%1$s {
				color: %2$s;
				background-color: %3$s;
				font-size: %4$spx;
				text-transform: %5$s;
			}',
			$button,
			$color_text,
			$color_bg,
			( ( $fontsize ) ?  intval( $fontsize ) : '' ),
			$text_transform
		);
		$css .= sprintf('
				%1$s:hover {
					color: %2$s;
					background-color: %3$s;
					border-color: %4$s;
				}
			',
			$button,
			$color_hover_text,
			$color_hover_bg,
			$color_hover_border
			);

		return $css;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {
	class WPBakeryShortCode_toolkit_button extends WPBakeryShortCode {
	}
}
