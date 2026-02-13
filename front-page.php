<?php
get_header();
?>

<div class="upaif-container">
	<section class="upaif-section upaif-two-col">
		<div>
			<img class="upaif-section-img" src="https://images.unsplash.com/photo-1606890658317-7d14490b76fd?auto=format&fit=crop&q=80&w=800" alt="">
		</div>
		<div class="upaif-content">
			<h2 class="upaif-section-title"><span><?php esc_html_e( 'Events', 'upaif' ); ?></span> <?php esc_html_e( '& Upplevelser', 'upaif' ); ?></h2>
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
			?>
			<a class="upaif-btn" href="#"><?php esc_html_e( 'BLI MEDLEM', 'upaif' ); ?></a>
		</div>
	</section>

	<section class="upaif-section upaif-two-col">
		<div class="upaif-content">
			<h2 class="upaif-section-title"><span><?php esc_html_e( 'Prova på!', 'upaif' ); ?></span></h2>
			<p><?php esc_html_e( 'Testa på pole och/eller aerial hoop innan du anmäler dig till en hel kurs. Prova på är helt gratis och erbjuds löpande under hela året.', 'upaif' ); ?></p>
			<a class="upaif-btn" href="<?php echo esc_url( home_url( '/klasser' ) ); ?>"><?php esc_html_e( 'ANMÄLAN', 'upaif' ); ?></a>
		</div>
		<div>
			<img class="upaif-section-img" src="https://images.unsplash.com/photo-1606890658317-7d14490b76fd?auto=format&fit=crop&q=80&w=800" alt="">
		</div>
	</section>

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
			$upaif_thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
			if ( ! $upaif_thumbnail_url ) {
				$upaif_thumbnail_url = 'https://images.unsplash.com/photo-1606890658317-7d14490b76fd?auto=format&fit=crop&q=80&w=800';
			}
			?>
			<section class="upaif-section upaif-two-col">
				<?php if ( $upaif_image_first ) : ?>
				<div>
					<img class="upaif-section-img" src="<?php echo esc_url( $upaif_thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				</div>
				<?php endif; ?>

				<div class="upaif-content">
					<?php the_title( '<h2 class="upaif-section-title upaif-post-title">', '</h2>' ); ?>
					<?php the_excerpt(); ?>
					<a class="upaif-btn upaif-btn--readmore" href="<?php the_permalink(); ?>"><?php echo esc_html( $upaif_read_more_text ); ?></a>
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
