<?php
get_header();
?>

<div class="upaif-container">
	<div class="upaif-content">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_title( '<h2 class="upaif-section-title upaif-post-title">', '</h2>' );
				the_excerpt();
				?>
				<p>
					<a class="upaif-btn upaif-btn--readmore" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'upaif' ); ?></a>
				</p>
				<?php
			}
		}
		?>
	</div>
</div>

<?php
get_footer();
