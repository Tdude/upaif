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
				$upaif_menu_cta_url = get_theme_mod( 'upaif_menu_cta_url', home_url( '/kalender' ) );
				$upaif_menu_cta_text = get_theme_mod( 'upaif_menu_cta_text', __( 'Klasser', 'upaif' ) );
				?>
				<a href="<?php echo esc_url( $upaif_menu_cta_url ); ?>"><?php echo esc_html( $upaif_menu_cta_text ); ?></a>
			</div>

			<?php
			$upaif_contact_url = trim( (string) get_theme_mod( 'upaif_contact_url', home_url( '/kontakt' ) ) );
			?>
			<?php if ( $upaif_contact_url ) : ?>
				<div class="upaif-nav__icons">
					<a class="upaif-icon-box" href="<?php echo esc_url( $upaif_contact_url ); ?>" aria-label="<?php esc_attr_e( 'Contact', 'upaif' ); ?>">
						<svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
					</a>
				</div>
			<?php endif; ?>
		</nav>

		<?php $upaif_hero_text_align = (string) get_theme_mod( 'upaif_hero_text_align', 'center' ); ?>
		<?php $upaif_hero_text_align = in_array( $upaif_hero_text_align, array( 'left', 'center', 'right' ), true ) ? $upaif_hero_text_align : 'center'; ?>
		<div class="upaif-hero__content upaif-hero__content--<?php echo esc_attr( $upaif_hero_text_align ); ?>">
			<?php if ( $upaif_is_front ) : ?>
				<h1 class="upaif-hero__title"><?php echo wp_kses_post( nl2br( esc_html( get_theme_mod( 'upaif_hero_title', "UPPSALA POLE\n& AERIALS" ) ) ) ); ?></h1>
				<p class="upaif-hero__subtitle"><?php echo esc_html( get_theme_mod( 'upaif_hero_subtitle', 'Dans – Hållbarhet – Gemenskap' ) ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	
	<main class="upaif-main" id="main">
