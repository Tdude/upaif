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
