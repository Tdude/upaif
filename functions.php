<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function upaif_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );	
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'upaif' ),
		)
	);
}
add_action( 'after_setup_theme', 'upaif_setup' );

function upaif_enqueue_assets() {
	wp_enqueue_style( 'upaif-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style(
		'upaif-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'upaif_enqueue_assets' );

function upaif_output_color_vars(): void {
	$bg_primary = get_theme_mod( 'upaif_color_bg_primary', '#f5f0e6' );
	$accent_gold = get_theme_mod( 'upaif_color_accent_gold', '#d4a373' );
	$accent_red = get_theme_mod( 'upaif_color_accent_red', '#9b2d30' );
	$text_dark = get_theme_mod( 'upaif_color_text_dark', '#2d1e12' );
	$text_light = get_theme_mod( 'upaif_color_text_light', '#5c4033' );
	$footer_bg = get_theme_mod( 'upaif_footer_bg_color', $accent_gold );
	$footer_text = get_theme_mod( 'upaif_footer_text_color', $text_dark );
	$header_sync_with_footer = absint( get_theme_mod( 'upaif_header_sync_with_footer', 1 ) );
	$footer_sync_with_header = absint( get_theme_mod( 'upaif_footer_sync_with_header', 0 ) );
	$header_bg_start = get_theme_mod( 'upaif_header_bg_start_color', '#e8d9c5' );
	$header_bg_end = get_theme_mod( 'upaif_header_bg_end_color', '#d4c0a0' );
	$hero_height = absint( get_theme_mod( 'upaif_hero_height_vh', 60 ) );
	$hero_overlay_direction = (string) get_theme_mod( 'upaif_hero_overlay_direction', 'rtl' );
	$hero_slant_deg = absint( get_theme_mod( 'upaif_hero_slant_deg', 20 ) );
	$footer_slant_deg = intval( get_theme_mod( 'upaif_footer_slant_deg', 0 ) );
	$hero_content_width = absint( get_theme_mod( 'upaif_hero_content_width_px', 1100 ) );
	$hero_title_size = (float) get_theme_mod( 'upaif_hero_title_size_rem', 6.2 );
	$hero_subtitle_size = (float) get_theme_mod( 'upaif_hero_subtitle_size_rem', 2.2 );
	$footer_title_width = absint( get_theme_mod( 'upaif_footer_title_width_px', 520 ) );
	$footer_title_size = (float) get_theme_mod( 'upaif_footer_title_size_rem', 3.0 );

	$bg_primary = sanitize_hex_color( $bg_primary ) ?: '#f5f0e6';
	$accent_gold = sanitize_hex_color( $accent_gold ) ?: '#d4a373';
	$accent_red = sanitize_hex_color( $accent_red ) ?: '#9b2d30';
	$text_dark = sanitize_hex_color( $text_dark ) ?: '#2d1e12';
	$text_light = sanitize_hex_color( $text_light ) ?: '#5c4033';
	$footer_bg = sanitize_hex_color( $footer_bg ) ?: $accent_gold;
	$footer_text = sanitize_hex_color( $footer_text ) ?: $text_dark;
	$header_bg_start = sanitize_hex_color( $header_bg_start ) ?: '#e8d9c5';
	$header_bg_end = sanitize_hex_color( $header_bg_end ) ?: '#d4c0a0';

	$hero_height = max( 30, min( 100, $hero_height ) );
	$hero_slant_deg = max( 0, min( 30, $hero_slant_deg ) );
	$footer_slant_deg = max( -30, min( 30, $footer_slant_deg ) );
	$hero_content_width = max( 420, min( 1600, $hero_content_width ) );
	$hero_title_size = max( 3.0, min( 10.0, $hero_title_size ) );
	$hero_subtitle_size = max( 1.0, min( 6.0, $hero_subtitle_size ) );
	$footer_title_width = max( 320, min( 1200, $footer_title_width ) );
	$footer_title_size = max( 1.6, min( 6.0, $footer_title_size ) );
	$hero_overlay_angle = $hero_overlay_direction === 'ltr' ? '270deg' : '90deg';
	$hero_slant_pct = round( ( $hero_slant_deg / 30 ) * 18, 2 );
	$footer_slant_pct = round( ( abs( $footer_slant_deg ) / 30 ) * 18, 2 );
	$footer_slant_left_pct = $footer_slant_deg < 0 ? $footer_slant_pct : 0;
	$footer_slant_right_pct = $footer_slant_deg > 0 ? $footer_slant_pct : 0;
	$footer_slant_left = $footer_slant_left_pct . '%';
	$footer_slant_right = $footer_slant_right_pct . '%';

	if ( $header_sync_with_footer ) {
		$header_bg_start = $footer_bg;
		$header_bg_end = $footer_bg;
	}

	if ( $footer_sync_with_header ) {
		$footer_bg = $header_bg_start;
		$footer_text = $text_dark;
	}

	$header_overlay_mid_rgba = 'rgba(232,217,197,0.65)';
	$header_overlay_end_rgba = 'rgba(212,192,160,0.98)';
	if ( preg_match( '/^#([a-fA-F0-9]{6})$/', $header_bg_start, $m ) ) {
		$hex = $m[1];
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		$header_overlay_mid_rgba = 'rgba(' . $r . ',' . $g . ',' . $b . ',0.65)';
	}
	if ( preg_match( '/^#([a-fA-F0-9]{6})$/', $header_bg_end, $m ) ) {
		$hex = $m[1];
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		$header_overlay_end_rgba = 'rgba(' . $r . ',' . $g . ',' . $b . ',0.98)';
	}

	$css = ':root{' .
		'--bg-primary:' . $bg_primary . ';' .
		'--accent-gold:' . $accent_gold . ';' .
		'--accent-red:' . $accent_red . ';' .
		'--text-dark:' . $text_dark . ';' .
		'--text-light:' . $text_light . ';' .
		'--header-bg-start:' . $header_bg_start . ';' .
		'--header-bg-end:' . $header_bg_end . ';' .
		'--header-overlay-mid:' . $header_overlay_mid_rgba . ';' .
		'--header-overlay-end:' . $header_overlay_end_rgba . ';' .
		'--footer-bg:' . $footer_bg . ';' .
		'--footer-text:' . $footer_text . ';' .
		'--hero-height:' . $hero_height . 'vh;' .
		'--hero-overlay-angle:' . $hero_overlay_angle . ';' .
		'--hero-slant-pct:' . $hero_slant_pct . ';' .
		'--footer-slant-left:' . $footer_slant_left . ';' .
		'--footer-slant-right:' . $footer_slant_right . ';' .
		'--hero-content-width:' . $hero_content_width . 'px;' .
		'--hero-title-size:' . $hero_title_size . 'rem;' .
		'--hero-subtitle-size:' . $hero_subtitle_size . 'rem;' .
		'--footer-title-width:' . $footer_title_width . 'px;' .
		'--footer-title-size:' . $footer_title_size . 'rem;' .
		'}';

	wp_add_inline_style( 'upaif-style', $css );
}
add_action( 'wp_enqueue_scripts', 'upaif_output_color_vars', 20 );

function upaif_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'upaif_theme',
		array(
			'title' => __( 'UPAIF Theme', 'upaif' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_section(
		'upaif_header',
		array(
			'title' => __( 'Header Settings', 'upaif' ),
			'priority' => 31,
		)
	);

	$wp_customize->add_section(
		'upaif_footer',
		array(
			'title' => __( 'Footer Settings', 'upaif' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_setting(
		'upaif_color_bg_primary',
		array(
			'default' => '#f5f0e6',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_color_bg_primary',
			array(
				'label' => __( 'Base background', 'upaif' ),
				'section' => 'upaif_theme',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_color_accent_gold',
		array(
			'default' => '#d4a373',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_color_accent_gold',
			array(
				'label' => __( 'Accent (gold)', 'upaif' ),
				'section' => 'upaif_theme',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_color_accent_red',
		array(
			'default' => '#9b2d30',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_color_accent_red',
			array(
				'label' => __( 'Accent (red)', 'upaif' ),
				'section' => 'upaif_theme',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_color_text_dark',
		array(
			'default' => '#2d1e12',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_color_text_dark',
			array(
				'label' => __( 'Text (dark)', 'upaif' ),
				'section' => 'upaif_theme',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_color_text_light',
		array(
			'default' => '#5c4033',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_color_text_light',
			array(
				'label' => __( 'Text (light)', 'upaif' ),
				'section' => 'upaif_theme',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_header_sync_with_footer',
		array(
			'default' => 1,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_header_sync_with_footer',
		array(
			'label' => __( 'Sync header colors with footer', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'upaif_header_bg_start_color',
		array(
			'default' => '#e8d9c5',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_header_bg_start_color',
			array(
				'label' => __( 'Header background (start)', 'upaif' ),
				'section' => 'upaif_header',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_header_bg_end_color',
		array(
			'default' => '#d4c0a0',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_header_bg_end_color',
			array(
				'label' => __( 'Header background (end)', 'upaif' ),
				'section' => 'upaif_header',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_title',
		array(
			'default' => "UPPSALA POLE\n& AERIALS",
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_title',
		array(
			'label' => __( 'Hero title', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_subtitle',
		array(
			'default' => 'Dans – Hållbarhet – Gemenskap',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_subtitle',
		array(
			'label' => __( 'Hero subtitle', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_height_vh',
		array(
			'default' => 60,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_height_vh',
		array(
			'label' => __( 'Hero height (vh)', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 30,
				'max' => 100,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_slant_deg',
		array(
			'default' => 20,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_slant_deg',
		array(
			'label' => __( 'Hero slant angle', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 0,
				'max' => 30,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_overlay_direction',
		array(
			'default' => 'rtl',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_overlay_direction',
		array(
			'label' => __( 'Hero overlay fade direction', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'select',
			'choices' => array(
				'rtl' => __( 'Right to left', 'upaif' ),
				'ltr' => __( 'Left to right', 'upaif' ),
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_content_width_px',
		array(
			'default' => 1100,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_content_width_px',
		array(
			'label' => __( 'Hero content width (px)', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 420,
				'max' => 1600,
				'step' => 10,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_title_size_rem',
		array(
			'default' => 6.2,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_title_size_rem',
		array(
			'label' => __( 'Hero title size (rem)', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 3,
				'max' => 10,
				'step' => 0.1,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_subtitle_size_rem',
		array(
			'default' => 2.2,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_subtitle_size_rem',
		array(
			'label' => __( 'Hero tagline size (rem)', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 1,
				'max' => 6,
				'step' => 0.1,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_text_align',
		array(
			'default' => 'center',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_text_align',
		array(
			'label' => __( 'Hero text alignment', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'select',
			'choices' => array(
				'left' => __( 'Left', 'upaif' ),
				'center' => __( 'Center', 'upaif' ),
				'right' => __( 'Right', 'upaif' ),
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_cta_title',
		array(
			'default' => 'Intresserad av gruppevent?',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_cta_title',
		array(
			'label' => __( 'Footer CTA title', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_slant_deg',
		array(
			'default' => 0,
			'sanitize_callback' => 'intval',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_slant_deg',
		array(
			'label' => __( 'Footer slant angle', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'range',
			'input_attrs' => array(
				'min' => -30,
				'max' => 30,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_sync_with_header',
		array(
			'default' => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_sync_with_header',
		array(
			'label' => __( 'Sync footer colors with header', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_title_width_px',
		array(
			'default' => 520,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_title_width_px',
		array(
			'label' => __( 'Footer text width (px)', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 320,
				'max' => 1200,
				'step' => 10,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_title_size_rem',
		array(
			'default' => 3.0,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_title_size_rem',
		array(
			'label' => __( 'Footer title size (rem)', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 1.6,
				'max' => 6,
				'step' => 0.1,
			),
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_bg_color',
		array(
			'default' => '#d4a373',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_footer_bg_color',
			array(
				'label' => __( 'Footer background', 'upaif' ),
				'section' => 'upaif_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_text_color',
		array(
			'default' => '#2d1e12',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upaif_footer_text_color',
			array(
				'label' => __( 'Footer text color', 'upaif' ),
				'section' => 'upaif_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_text',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_text',
		array(
			'label' => __( 'Footer text', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_email',
		array(
			'default' => 'info@uppsalapoleandaerials.se',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_email',
		array(
			'label' => __( 'Footer email', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_instagram_url',
		array(
			'default' => 'https://instagram.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_instagram_url',
		array(
			'label' => __( 'Instagram URL', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'url',
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_facebook_url',
		array(
			'default' => 'https://facebook.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_facebook_url',
		array(
			'label' => __( 'Facebook URL', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'url',
		)
	);

	$wp_customize->add_setting(
		'upaif_contact_url',
		array(
			'default' => home_url( '/kontakt' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'upaif_contact_url',
		array(
			'label' => __( 'Contact page URL', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'url',
		)
	);

	$wp_customize->add_setting(
		'upaif_read_more_text',
		array(
			'default' => __( 'Read more', 'upaif' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_read_more_text',
		array(
			'label' => __( 'Read more button text', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_menu_cta_text',
		array(
			'default' => __( 'Anmälan', 'upaif' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_menu_cta_text',
		array(
			'label' => __( 'Menu button text', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_menu_cta_url',
		array(
			'default' => home_url( '/klasser' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'upaif_menu_cta_url',
		array(
			'label' => __( 'Menu button URL', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'url',
		)
	);
}
add_action( 'customize_register', 'upaif_customize_register' );
