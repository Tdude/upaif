<?php
get_header();
?>

<div class="upaif-container">
	<section class="upaif-section upaif-two-col">
		<div>
			<img class="upaif-section-img" src="https://images.unsplash.com/photo-1606890658317-7d14490b76fd?auto=format&fit=crop&q=80&w=800" alt="">
		</div>
		<div class="upaif-content">
			<h2 class="upaif-section-title"><span><?php esc_html_e( 'Någon fin rubrik', 'upaif' ); ?></span> <?php esc_html_e( 'om föreningen', 'upaif' ); ?></h2>
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
			<h2 class="upaif-section-title"><span><?php esc_html_e( 'På gång!', 'upaif' ); ?></span></h2>
			<p><?php esc_html_e( 'Lägg valfritt innehåll här i nästa steg (t.ex. nyheter eller kommande event).', 'upaif' ); ?></p>
			<a class="upaif-btn" href="<?php echo esc_url( home_url( '/klasser' ) ); ?>"><?php esc_html_e( 'ANMÄLAN', 'upaif' ); ?></a>
		</div>
		<div>
			<img class="upaif-section-img" src="https://images.unsplash.com/photo-1606890658317-7d14490b76fd?auto=format&fit=crop&q=80&w=800" alt="">
		</div>
	</section>

	<section class="upaif-section">
		<div class="upaif-content">
			<h2 class="upaif-section-title"><span><?php esc_html_e( 'Nyheter', 'upaif' ); ?></span></h2>
			<?php
			$upaif_read_more_text = get_theme_mod( 'upaif_read_more_text', __( 'Read more', 'upaif' ) );
			$upaif_news_query = new WP_Query(
				array(
					'post_type' => 'post',
					'posts_per_page' => 3,
					'ignore_sticky_posts' => true,
					'category_name' => 'nyheter',
				)
			);

			if ( $upaif_news_query->have_posts() ) {
				while ( $upaif_news_query->have_posts() ) {
					$upaif_news_query->the_post();
					?>
					<a class="upaif-news-card" href="<?php the_permalink(); ?>">
						<div class="upaif-news-card__inner">
							<?php
							the_title( '<h3 class="upaif-section-title upaif-post-title">', '</h3>' );
							the_excerpt();
							?>
							<p>
								<span class="upaif-btn upaif-btn--readmore"><?php echo esc_html( $upaif_read_more_text ); ?></span>
							</p>
						</div>
					</a>
					<?php
				}
				wp_reset_postdata();
			} else {
				wp_reset_postdata();
			}
			?>
		</div>
	</section>
</div>

<?php
get_footer();
