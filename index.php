<?php
get_header();
?>

<div class="upaif-container">
	<div class="upaif-content">
		<?php
		$upaif_read_more_text = get_theme_mod( 'upaif_read_more_text', __( 'Read more', 'upaif' ) );
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$upaif_permalink = get_permalink();
				?>
				<article class="upaif-clickable-post" data-permalink="<?php echo esc_url( $upaif_permalink ); ?>" tabindex="0" role="link" aria-label="<?php echo esc_attr( wp_strip_all_tags( get_the_title() ) ); ?>">
					<?php the_title( '<h2 class="upaif-section-title upaif-post-title">', '</h2>' ); ?>
					<?php the_excerpt(); ?>
				<p>
					<a class="upaif-btn upaif-btn--readmore" href="<?php echo esc_url( $upaif_permalink ); ?>"><?php echo esc_html( $upaif_read_more_text ); ?></a>
				</p>
				</article>
				<?php
			}
		}
		?>
	</div>
</div>

<?php
get_footer();
