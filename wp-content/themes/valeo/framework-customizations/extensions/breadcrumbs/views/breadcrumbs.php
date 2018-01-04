<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
} ?>

<?php if ( ! empty( $items ) ) : ?>
	<div class="breadcrumbs">
		<?php for ( $i = 0; $i < count( $items ); $i ++ ) : ?>
			<?php if ( $i == ( count( $items ) - 1 ) ) : ?>
				<span class="last-item"><?php echo esc_attr($items[ $i ]['name']) ?></span>
			<?php elseif ( $i == 0 ) : ?>
				<span class="first-item">
				<?php if( isset( $items[ $i ]['url'] ) ) : ?>
					<a href="<?php echo esc_url($items[ $i ]['url']) ?>"><?php echo esc_attr($items[ $i ]['name']) ?></a></span>
				<?php else : echo esc_attr($items[ $i ]['name']); endif ?>
				<span class="separator"><?php echo esc_attr($separator) ?></span>
			<?php
			else : ?>
				<span class="<?php echo( $i - 1 ) ?>-item">
					<?php if( isset( $items[ $i ]['url'] ) ) : ?>
						<a href="<?php echo esc_url($items[ $i ]['url']) ?>"><?php echo esc_attr($items[ $i ]['name']) ?></a></span>
					<?php else : echo esc_attr($items[ $i ]['name']); endif ?>
				<span class="separator"><?php echo esc_attr($separator) ?></span>
			<?php endif ?>
		<?php endfor ?>
	</div>
<?php endif ?>