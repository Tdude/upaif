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
	$hero_height = absint( get_theme_mod( 'upaif_hero_height_vh', 60 ) );
	$hero_overlay_direction = (string) get_theme_mod( 'upaif_hero_overlay_direction', 'rtl' );
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

	$hero_height = max( 30, min( 100, $hero_height ) );
	$hero_content_width = max( 420, min( 1600, $hero_content_width ) );
	$hero_title_size = max( 3.0, min( 10.0, $hero_title_size ) );
	$hero_subtitle_size = max( 1.0, min( 6.0, $hero_subtitle_size ) );
	$footer_title_width = max( 320, min( 1200, $footer_title_width ) );
	$footer_title_size = max( 1.6, min( 6.0, $footer_title_size ) );
	$hero_overlay_angle = $hero_overlay_direction === 'ltr' ? '270deg' : '90deg';

	$css = ':root{' .
		'--bg-primary:' . $bg_primary . ';' .
		'--accent-gold:' . $accent_gold . ';' .
		'--accent-red:' . $accent_red . ';' .
		'--text-dark:' . $text_dark . ';' .
		'--text-light:' . $text_light . ';' .
		'--footer-bg:' . $footer_bg . ';' .
		'--footer-text:' . $footer_text . ';' .
		'--hero-height:' . $hero_height . 'vh;' .
		'--hero-overlay-angle:' . $hero_overlay_angle . ';' .
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
		'upaif_footer',
		array(
			'title' => __( 'Footer Settings', 'upaif' ),
			'priority' => 31,
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
			'type' => 'range',
			'input_attrs' => array(
				'min' => 30,
				'max' => 100,
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
			'type' => 'url',
		)
	);
}
add_action( 'customize_register', 'upaif_customize_register' );
