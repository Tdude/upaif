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
	<header class="upaif-hero">
		<div class="upaif-hero__bg"></div>

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
				<a href="<?php echo esc_url( home_url( '/klasser' ) ); ?>"><?php esc_html_e( 'Anmälan', 'upaif' ); ?></a>
			</div>

			<div class="upaif-nav__icons" aria-hidden="true">
				<div class="upaif-icon-box">
					<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.32-1.45 5.12-3.5h-10.25c.8 2.05 2.79 3.5 5.13 3.5z"/></svg>
				</div>
				<div class="upaif-icon-box">
					<svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg>
				</div>
				<div class="upaif-icon-box">
					<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
				</div>
			</div>
		</nav>

		<div class="upaif-hero__content">
			<h1 class="upaif-hero__title"><?php echo wp_kses_post( nl2br( esc_html__( 'UPPSALA POLE
& AERIALS', 'upaif' ) ) ); ?></h1>
			<p class="upaif-hero__subtitle"><?php esc_html_e( 'Dans – Hållbarhet – Gemenskap', 'upaif' ); ?></p>
		</div>
	</header>
	
	<main class="upaif-main" id="main">
