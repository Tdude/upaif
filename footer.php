	</main>

	<footer class="upaif-footer">
		<div class="upaif-cta-diagonal">
			<div class="upaif-cta-content">
				<h2 class="upaif-cta-title"><?php echo esc_html( get_theme_mod( 'upaif_footer_cta_title', 'Intresserad av gruppevent?' ) ); ?></h2>
				<div class="upaif-social">
					<?php
					$upaif_instagram_url = trim( (string) get_theme_mod( 'upaif_footer_instagram_url', '' ) );
					$upaif_facebook_url = trim( (string) get_theme_mod( 'upaif_footer_facebook_url', '' ) );
					?>
					<?php if ( $upaif_instagram_url ) : ?>
						<a class="upaif-social__icon" href="<?php echo esc_url( $upaif_instagram_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'upaif' ); ?>">
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 4a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm5.5-.9a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2z"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $upaif_facebook_url ) : ?>
						<a class="upaif-social__icon" href="<?php echo esc_url( $upaif_facebook_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'upaif' ); ?>">
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3H13.5V9.1c0-.9.2-1.5 1.6-1.5H16.7V5c-.3 0-1.5-.1-2.8-.1-2.8 0-4.7 1.7-4.7 4.8V11H6.7v3h2.5v8h4.3z"/></svg>
						</a>
					<?php endif; ?>
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
