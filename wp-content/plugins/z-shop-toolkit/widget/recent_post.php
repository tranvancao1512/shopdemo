<?php
/**
 * Recent post widget.
 *
 * @package Basr Core
 * @author  LunarTheme
 * @link http://www.lunartheme.com
 */

add_action( 'widgets_init', 'basr_core_recent_post_load_widgets' );
function basr_core_recent_post_load_widgets() {
	register_widget( 'Basr_Core_Widget_Recent_Post' );
}
class Basr_Core_Widget_Recent_Post extends WP_Widget {

	function __construct() {
		$widget_ops  = array( 'classname' => 'basr_core_widget_latest_posts', 'description' => '' );
		$control_ops = array( 'width' => 250, 'height' => 350 );
		parent::__construct( 'k2t_recent_post', strtoupper( BASR_CORE ) . esc_html__( ' - Recent Post', 'basr-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo ( $before_widget );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( ! empty( $title ) ) {
			echo ( $before_title );
			echo esc_html($title) ;
			echo ( $after_title );
		}

		// Load parameter
		$limit         = isset( $instance['limit'] ) ? $instance['limit'] : '';
		$order         = isset( $instance['order'] ) ? $instance['order'] : '';
		$orderby       = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
		$display_thumb = isset( $instance['display_thumb'] ) ? $instance['display_thumb'] : '';
		$display_date  = isset( $instance['display_date'] ) ? $instance['display_date'] : '';

		// Load data
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
		);
		if ( ! empty( $limit ) ) $args['posts_per_page'] = $limit;
		if ( ! empty( $order ) ) $args['order'] = $order;
		if ( ! empty( $orderby ) ) $args['orderby'] = $orderby;

		$recent_posts = new WP_query( $args );
		$html = '';
		$html .= '<div class="posts-list">';
		while ( $recent_posts->have_posts() ) : $recent_posts->the_post();

			if ( has_post_thumbnail( get_the_ID() ) ) {
			    $thumb = get_the_post_thumbnail( get_the_ID(), BASR_CORE . '-thumbnail-avatar' );
			} else {
				// $thumb = '<img src="' . get_template_directory_uri() . '/assets/img/placeholder/basr_core_recent_post.jpg" alt="' . trim( get_the_title() ) . '" />';
			}
			$thumb_html = $date_html = '';
			if ( $display_thumb == 'show' ) {
				$thumb_html = '
					<div class="post-thumb">
						<a href="' . get_permalink( get_the_ID() ) . '" title="' . get_the_title() . '">' . $thumb . '</a>
					</div>
				';
			}
			if ( $display_date == 'show' ) {

				$date_html = '
					<div class="post-meta">
						<span>' . get_the_date( 'F d, Y' ) . '</span>
					</div>
				';
			}
			$html .= '
				<article class="post-item">
					' . $thumb_html . '
					<div class="post-text">
						<h4><a href="' . get_permalink( get_the_ID() ) . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h4>' .
						$date_html .
					'</div>' .
				'</article>';
		endwhile;
		$html .= '</div>';

		echo ( $html );
		echo ( $after_widget );
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		return $new_instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => esc_html__( 'Recent Post', 'basr-core' ), 'limit' => 5, 'order' => 'desc', 'orderby' => 'title', 'display_thumb' => 'show', 'display_date' => 'show' );
		$instance = wp_parse_args( (array) $instance, $defaults );?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'basr-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Limit:', 'basr-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
		</p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order:', 'basr-core' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
                <option <?php selected( $instance['order'], 'desc' ) ?> value="desc"><?php esc_html_e( 'DESC', 'basr-core' );?></option>
                <option <?php selected( $instance['order'], 'asc' ) ?> value="asc"><?php esc_html_e( 'ASC', 'basr-core' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Orderby:', 'basr-core' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
                <option <?php selected( $instance['orderby'], 'title' ) ?> value="title"><?php esc_html_e( 'Title', 'basr-core' );?></option>
                <option <?php selected( $instance['orderby'], 'post_date' ) ?> value="post_date"><?php esc_html_e( 'Date', 'basr-core' );?></option>
                <option <?php selected( $instance['orderby'], 'rand' ) ?> value="rand"><?php esc_html_e( 'Random', 'basr-core' );?></option>
            </select>
        </p>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_thumb' ) ); ?>"><?php esc_html_e( 'Display Thumbnail:', 'basr-core' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_thumb' ) ); ?>">
                <option <?php selected( $instance['display_thumb'], 'show' ) ?> value="show"><?php esc_html_e( 'Show', 'basr-core' );?></option>
                <option <?php selected( $instance['display_thumb'], 'hided' ) ?> value="hided"><?php esc_html_e( 'Hide', 'basr-core' );?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>"><?php esc_html_e( 'Display Date:', 'basr-core' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_date' ) ); ?>">
                <option <?php selected( $instance['display_date'], 'show' ) ?> value="show"><?php esc_html_e( 'Show', 'basr-core' );?></option>
                <option <?php selected( $instance['display_date'], 'hided' ) ?> value="hided"><?php esc_html_e( 'Hide', 'basr-core' );?></option>
            </select>
        </p>
		<?php
	}
}
?>
