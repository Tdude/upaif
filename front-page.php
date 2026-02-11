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
</div>

<?php
get_footer();
