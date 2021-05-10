<?php
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>
<div class="<?php echo esc_attr( $class ); ?>">
	<ul class="wrap-social-button social social-info">

		<?php 
		$social_list = basr_core_get_setting( 'social_links' );
		foreach( $options['social_list'] as $name => $value ):
			if( ! $value ) continue;
			$link = $social_list[$name];
			$name = str_replace('_', '', $name);?>
			<li>
				<a target="_blank" href="<?php echo esc_url($link); ?>" class="<?php echo esc_url($name); ?>">
					<i class="fa fa-<?php echo esc_attr($name) ?>"></i>
				</a>
			</li>
		<?php 
		endforeach; ?>

	</ul>
</div>
