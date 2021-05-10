<?php 


class toolkit_basr_shortcode_page_nav_item extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'page_nav_item';

	// public $animation = 'true';  //  enable this to use make shortcode support animation

	// this->base = $prefix + $shortcode;

	// register script 

	public function register_script ( ) {

	}

	// Enqueue script, style 

	public function enqueue_script ( $extra = array() ) {
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
						'base' 				=> $this->base,
						'name' 				=> esc_html__( 'Sections', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_child'			=> array( 'only' => $this->prefix . 'page_nav' ),
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),

							array(
								'param_name'  => 'title',
								'heading'     => esc_html__( 'Title', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'		  => 'textfield',
							),

							array(
								'param_name'  => 'section_id',
								'heading'     => esc_html__( 'Section id', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'		  => 'textfield',
							),

							toolkit_basr_vcf_class(),
						),
					) 
				);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {

		$sc_atts =  array( 
						$this->base . '_id' 				=> ''				,

						// atts here  
						'title'								=> '',
						'section_id'						=> '',
						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> ''			,
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue 

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here


		// Start out put

		$output = '<li class="page-nav-item" data-section="' . $section_id . '"><a href="#' . $section_id . '">' . $title . '</a></li>'; 

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

}

