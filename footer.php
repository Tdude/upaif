	</main>

	<footer class="upaif-footer">
		<div class="upaif-cta-diagonal">
			<div class="upaif-cta-content">
				<h2 class="upaif-cta-title"><?php echo esc_html( get_theme_mod( 'upaif_footer_cta_title', 'Intresserad av gruppevent?' ) ); ?></h2>
				<div class="upaif-social">
					<a href="<?php echo esc_url( get_theme_mod( 'upaif_footer_instagram_url', 'https://instagram.com' ) ); ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
					<span aria-hidden="true"> • </span>
					<a href="<?php echo esc_url( get_theme_mod( 'upaif_footer_facebook_url', 'https://facebook.com' ) ); ?>" target="_blank" rel="noopener noreferrer">Facebook</a>
				</div>
				<p>
					<?php $upaif_footer_email = get_theme_mod( 'upaif_footer_email', 'info@uppsalapoleandaerials.se' ); ?>
					<a href="mailto:<?php echo esc_attr( $upaif_footer_email ); ?>"><?php echo esc_html( $upaif_footer_email ); ?></a>
				</p>
			</div>
		</div>
		<p>
			<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'upaif' ); ?></a>
			<span aria-hidden="true"> • </span>
			<a href="<?php echo esc_url( home_url( '/terms' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'upaif' ); ?></a>
		</p>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
