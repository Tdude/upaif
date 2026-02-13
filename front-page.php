<?php
get_header();
?>

<div class="upaif-container">


	<?php
	$upaif_read_more_text = get_theme_mod( 'upaif_read_more_text', __( 'Read more', 'upaif' ) );
	$upaif_news_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 2,
			'ignore_sticky_posts' => true,
		)
	);

	if ( $upaif_news_query->have_posts() ) {
		$upaif_news_index = 0;
		while ( $upaif_news_query->have_posts() ) {
			$upaif_news_query->the_post();
			$upaif_news_index++;
			$upaif_image_first = ( $upaif_news_index % 2 === 1 ); // Odd = image left, Even = image right
			$upaif_permalink = get_permalink();
			$upaif_thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
			if ( ! $upaif_thumbnail_url ) {
				$upaif_thumbnail_url = 'https://images.unsplash.com/photo-1606890658317-7d14490b76fd?auto=format&fit=crop&q=80&w=800';
			}
			?>
			<section class="upaif-section upaif-two-col upaif-clickable-post" data-permalink="<?php echo esc_url( $upaif_permalink ); ?>" tabindex="0" role="link" aria-label="<?php echo esc_attr( wp_strip_all_tags( get_the_title() ) ); ?>">
				<?php if ( $upaif_image_first ) : ?>
				<div>
					<img class="upaif-section-img" src="<?php echo esc_url( $upaif_thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				</div>
				<?php endif; ?>

				<div class="upaif-content">
					<?php
					$upaif_title = get_the_title();
					$upaif_title_words = explode( ' ', $upaif_title, 2 );
					$upaif_first_word = $upaif_title_words[0];
					$upaif_rest = isset( $upaif_title_words[1] ) ? ' ' . $upaif_title_words[1] : '';
					$upaif_color_class = ( $upaif_news_index % 2 === 1 ) ? 'upaif-title--black-red' : 'upaif-title--red-black';
					?>
					<h2 class="upaif-section-title upaif-post-title <?php echo esc_attr( $upaif_color_class ); ?>">
						<span class="upaif-title__first"><?php echo esc_html( $upaif_first_word ); ?></span><?php echo esc_html( $upaif_rest ); ?>
					</h2>
					<?php the_excerpt(); ?>
					<a class="upaif-btn upaif-btn--readmore" href="<?php echo esc_url( $upaif_permalink ); ?>"><?php echo esc_html( $upaif_read_more_text ); ?></a>
				</div>

				<?php if ( ! $upaif_image_first ) : ?>
				<div>
					<img class="upaif-section-img" src="<?php echo esc_url( $upaif_thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				</div>
				<?php endif; ?>
			</section>
			<?php
		}
		wp_reset_postdata();
	}
	?>
</div>

<?php
get_footer();
