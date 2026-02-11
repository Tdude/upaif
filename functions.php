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

function upaif_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'upaif_theme',
		array(
			'title' => __( 'UPAIF Theme', 'upaif' ),
			'priority' => 30,
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
			'section' => 'upaif_theme',
			'type' => 'text',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
			'section' => 'upaif_theme',
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
}
add_action( 'customize_register', 'upaif_customize_register' );
