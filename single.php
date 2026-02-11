<?php
get_header();
?>

<div class="upaif-container">
	<div class="upaif-content">
		<?php
		while ( have_posts() ) {
			the_post();
			the_title( '<h1 class="upaif-section-title upaif-post-title">', '</h1>' );
			the_content();
		}
		?>
	</div>
</div>

<?php
get_footer();
