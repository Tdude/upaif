	</main>

	<footer class="upaif-footer">
		<div class="upaif-cta-diagonal">
			<div class="upaif-cta-content">
				<div class="upaif-footer__top">
					<div class="upaif-footer__left">
						<h2 class="upaif-cta-title"><?php echo esc_html( get_theme_mod( 'upaif_footer_cta_title', 'Intresserad av gruppevent?' ) ); ?></h2>
						<?php $upaif_footer_text = trim( (string) get_theme_mod( 'upaif_footer_text', '' ) ); ?>
						<?php if ( $upaif_footer_text ) : ?>
							<p class="upaif-footer__text"><?php echo nl2br( esc_html( $upaif_footer_text ) ); ?></p>
						<?php endif; ?>

					</div>
					<div class="upaif-footer__right">
						<?php
						$upaif_instagram_url = trim( (string) get_theme_mod( 'upaif_footer_instagram_url', '' ) );
						$upaif_facebook_url = trim( (string) get_theme_mod( 'upaif_footer_facebook_url', '' ) );
						?>
						<?php if ( $upaif_instagram_url || $upaif_facebook_url ) : ?>
							<div class="upaif-social">
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
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="upaif-footer__legal">
			<?php $upaif_footer_email = trim( (string) get_theme_mod( 'upaif_footer_email', '' ) ); ?>
			<?php if ( $upaif_footer_email ) : ?>
				<div class="upaif-footer__legal-left">
					<a class="upaif-footer__legal-email" href="mailto:<?php echo esc_attr( $upaif_footer_email ); ?>" aria-label="<?php esc_attr_e( 'Email', 'upaif' ); ?>">
						<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
						<span><?php echo esc_html( $upaif_footer_email ); ?></span>
					</a>
				</div>
			<?php endif; ?>
			<div class="upaif-footer__legal-right">
				<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'upaif' ); ?></a>
				<span aria-hidden="true"> • </span>
				<a href="<?php echo esc_url( home_url( '/terms' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'upaif' ); ?></a>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
