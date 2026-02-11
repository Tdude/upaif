<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="upaif-site">
	<?php
	$upaif_is_front = is_front_page();
	$upaif_header_title = '';
	if ( ! $upaif_is_front ) {
		if ( is_singular() ) {
			$upaif_header_title = single_post_title( '', false );
		} elseif ( is_home() ) {
			$upaif_posts_page_id = (int) get_option( 'page_for_posts' );
			$upaif_header_title = $upaif_posts_page_id ? get_the_title( $upaif_posts_page_id ) : __( 'Posts', 'upaif' );
		} elseif ( is_archive() ) {
			$upaif_header_title = get_the_archive_title();
		} elseif ( is_search() ) {
			$upaif_header_title = __( 'Search', 'upaif' );
		} else {
			$upaif_header_title = wp_get_document_title();
		}
	}
	?>
	<?php
	$upaif_hero_image_url = '';
	$upaif_thumbnail_id = get_post_thumbnail_id( get_queried_object_id() );
	if ( $upaif_thumbnail_id ) {
		$upaif_hero_image_url = (string) wp_get_attachment_image_url( $upaif_thumbnail_id, 'full' );
	}
	if ( ! $upaif_hero_image_url ) {
		$upaif_hero_image_url = 'https://images.unsplash.com/photo-1519741497674-8b6947c5a348?auto=format&fit=crop&q=80&w=2000';
	}
	?>
	<header class="upaif-hero<?php echo $upaif_is_front ? '' : ' upaif-hero--small'; ?>">
		<div class="upaif-hero__bg" style="background-image: url('<?php echo esc_url( $upaif_hero_image_url ); ?>');"></div>
		<div class="upaif-hero__overlay" aria-hidden="true"></div>

		<nav class="upaif-nav" aria-label="<?php esc_attr_e( 'Primary', 'upaif' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'upaif-menu',
					'fallback_cb' => false,
				)
			);
			?>

			<div class="upaif-nav__cta">
				<?php
				$upaif_menu_cta_url = get_theme_mod( 'upaif_menu_cta_url', home_url( '/klasser' ) );
				$upaif_menu_cta_text = get_theme_mod( 'upaif_menu_cta_text', __( 'Anmälan', 'upaif' ) );
				?>
				<a href="<?php echo esc_url( $upaif_menu_cta_url ); ?>"><?php echo esc_html( $upaif_menu_cta_text ); ?></a>
			</div>

			<?php
			$upaif_instagram_url = trim( (string) get_theme_mod( 'upaif_footer_instagram_url', 'https://instagram.com' ) );
			$upaif_facebook_url = trim( (string) get_theme_mod( 'upaif_footer_facebook_url', 'https://facebook.com' ) );
			$upaif_contact_url = trim( (string) get_theme_mod( 'upaif_contact_url', home_url( '/kontakt' ) ) );
			?>
			<?php if ( $upaif_instagram_url || $upaif_facebook_url || $upaif_contact_url ) : ?>
				<div class="upaif-nav__icons">
					<?php if ( $upaif_instagram_url ) : ?>
						<a class="upaif-icon-box" href="<?php echo esc_url( $upaif_instagram_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'upaif' ); ?>">
							<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.32-1.45 5.12-3.5h-10.25c.8 2.05 2.79 3.5 5.13 3.5z"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $upaif_facebook_url ) : ?>
						<a class="upaif-icon-box" href="<?php echo esc_url( $upaif_facebook_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'upaif' ); ?>">
							<svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $upaif_contact_url ) : ?>
						<a class="upaif-icon-box" href="<?php echo esc_url( $upaif_contact_url ); ?>" aria-label="<?php esc_attr_e( 'Contact', 'upaif' ); ?>">
							<svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</nav>

		<div class="upaif-hero__content">
			<?php if ( $upaif_is_front ) : ?>
				<h1 class="upaif-hero__title"><?php echo wp_kses_post( nl2br( esc_html( get_theme_mod( 'upaif_hero_title', "UPPSALA POLE\n& AERIALS" ) ) ) ); ?></h1>
				<p class="upaif-hero__subtitle"><?php echo esc_html( get_theme_mod( 'upaif_hero_subtitle', 'Dans – Hållbarhet – Gemenskap' ) ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	
	<main class="upaif-main" id="main">
