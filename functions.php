<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function upaif_setup() {
	load_theme_textdomain( 'upaif', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );	
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'upaif' ),
		)
	);
}
add_action( 'after_setup_theme', 'upaif_setup' );

/**
 * Rename "Posts" to "Nyheter" in admin menu.
 */
function upaif_rename_posts_menu() {
	global $menu, $submenu;
	
	// Main menu item
	if ( isset( $menu[5] ) ) {
		$menu[5][0] = 'Nyheter';
	}
	
	// Submenu items
	if ( isset( $submenu['edit.php'] ) ) {
		$submenu['edit.php'][5][0]  = 'Alla nyheter';
		$submenu['edit.php'][10][0] = 'Skapa nyhet';
	}
}
add_action( 'admin_menu', 'upaif_rename_posts_menu' );

/**
 * Rename "Post" labels throughout admin.
 */
function upaif_rename_post_labels( $labels ) {
	$labels->name               = 'Nyheter';
	$labels->singular_name      = 'Nyhet';
	$labels->add_new            = 'Skapa ny';
	$labels->add_new_item       = 'Skapa ny nyhet';
	$labels->edit_item          = 'Redigera nyhet';
	$labels->new_item           = 'Ny nyhet';
	$labels->view_item          = 'Visa nyhet';
	$labels->search_items       = 'Sök nyheter';
	$labels->not_found          = 'Inga nyheter hittades';
	$labels->not_found_in_trash = 'Inga nyheter i papperskorgen';
	$labels->all_items          = 'Alla nyheter';
	$labels->menu_name          = 'Nyheter';
	$labels->name_admin_bar     = 'Nyhet';
	return $labels;
}
add_filter( 'post_type_labels_post', 'upaif_rename_post_labels' );

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

/**
 * Mobile menu toggle script
 */
function upaif_mobile_menu_script() {
	?>
	<script>
	(function() {
		var nav = document.querySelector('.upaif-nav');
		var toggle = document.querySelector('.upaif-nav__toggle');
		if (!nav || !toggle) return;

		var DESKTOP_BREAKPOINT = 768;
		var desktopHideOffset = 140;
		var desktopTopSafeZone = 90;
		var desktopDeltaThreshold = 12;
		var navHidden = false;
		var lastScrollY = window.scrollY || window.pageYOffset || 0;
		var scrollTicking = false;
		var isMobile = function() { return window.innerWidth <= DESKTOP_BREAKPOINT; };

		var setDesktopNavHidden = function(shouldHide) {
			if (navHidden === shouldHide) return;
			navHidden = shouldHide;
			nav.classList.toggle('is-hidden', shouldHide);
		};

		var updateDesktopNavVisibility = function() {
			var currentY = window.scrollY || window.pageYOffset || 0;
			var delta = currentY - lastScrollY;

			if (currentY <= desktopTopSafeZone) {
				setDesktopNavHidden(false);
				lastScrollY = currentY;
				return;
			}

			if (Math.abs(delta) < desktopDeltaThreshold) {
				return;
			}

			if (delta > 0 && currentY > desktopHideOffset) {
				setDesktopNavHidden(true);
			} else {
				setDesktopNavHidden(false);
			}

			lastScrollY = currentY;
		};

		window.addEventListener('scroll', function() {
			if (isMobile()) {
				setDesktopNavHidden(false);
				lastScrollY = window.scrollY || window.pageYOffset || 0;
				return;
			}

			if (scrollTicking) return;
			scrollTicking = true;

			window.requestAnimationFrame(function() {
				updateDesktopNavVisibility();
				scrollTicking = false;
			});
		}, { passive: true });

		window.addEventListener('resize', function() {
			if (isMobile()) {
				setDesktopNavHidden(false);
			}
			lastScrollY = window.scrollY || window.pageYOffset || 0;
		});
		
		// Hamburger always toggles
		toggle.addEventListener('click', function(e) {
			e.stopPropagation();
			var isOpen = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			document.body.classList.toggle('upaif-menu-open', isOpen);
		});
		
		// Tap anywhere on closed nav to open (mobile only)
		nav.addEventListener('click', function(e) {
			if (window.innerWidth > 768) return;
			if (nav.classList.contains('is-open')) return;
			// Don't trigger if clicking toggle (handled above)
			if (e.target.closest('.upaif-nav__toggle')) return;
			
			nav.classList.add('is-open');
			toggle.setAttribute('aria-expanded', 'true');
			document.body.classList.add('upaif-menu-open');
		});
		
		// Mobile submenu toggles
		var subMenuParents = nav.querySelectorAll('.menu-item-has-children');
		
		subMenuParents.forEach(function(item) {
			// Create toggle button for mobile
			var btn = document.createElement('button');
			btn.className = 'upaif-submenu-toggle';
			btn.setAttribute('aria-label', 'Toggle submenu');
			btn.setAttribute('aria-expanded', 'false');
			item.appendChild(btn);
			
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				if (!isMobile()) return;
				
				var isOpen = item.classList.toggle('submenu-open');
				btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			});
			
			// Prevent parent link from navigating if it's just "#" (dropdown parent)
			var parentLink = null;
			for (var i = 0; i < item.children.length; i++) {
				if (item.children[i].tagName && item.children[i].tagName.toUpperCase() === 'A') {
					parentLink = item.children[i];
					break;
				}
			}
			if (parentLink && parentLink.getAttribute('href') === '#') {
				parentLink.addEventListener('click', function(e) {
					if (isMobile()) {
						e.preventDefault();
						item.classList.toggle('submenu-open');
						btn.setAttribute('aria-expanded', item.classList.contains('submenu-open') ? 'true' : 'false');
					}
				});
			}
		});
		
		// Close menu when clicking a link (but not submenu toggles or parent links)
		var links = nav.querySelectorAll('.upaif-menu a, .upaif-nav__cta a');
		links.forEach(function(link) {
			link.addEventListener('click', function(e) {
				// Don't close if it's a parent with # href
				if (link.getAttribute('href') === '#') return;
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				document.body.classList.remove('upaif-menu-open');
			});
		});
		
		// Close menu when clicking outside
		document.addEventListener('click', function(e) {
			if (!nav.contains(e.target) && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				document.body.classList.remove('upaif-menu-open');
			}
		});

		var clickablePosts = document.querySelectorAll('.upaif-clickable-post[data-permalink]');
		var shouldIgnorePostClick = function(target) {
			if (!target || !target.closest) return false;
			return !!target.closest('a, button, input, select, textarea, label, summary, [role="button"], [contenteditable="true"]');
		};

		clickablePosts.forEach(function(post) {
			var permalink = post.getAttribute('data-permalink');
			if (!permalink) return;

			post.addEventListener('click', function(e) {
				if (shouldIgnorePostClick(e.target)) {
					return;
				}
				if (window.getSelection && window.getSelection().toString().length > 0) {
					return;
				}
				window.location.href = permalink;
			});

			post.addEventListener('keydown', function(e) {
				if (e.key !== 'Enter' && e.key !== ' ') {
					return;
				}
				if (shouldIgnorePostClick(e.target)) {
					return;
				}
				e.preventDefault();
				window.location.href = permalink;
			});
		});
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'upaif_mobile_menu_script' );

/**
 * Sanitize integer for customizer (intval wrapper that ignores extra args)
 */
function upaif_sanitize_int( $value ) {
	return intval( $value );
}

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
	$hero_slant_deg = intval( get_theme_mod( 'upaif_hero_slant_deg', 0 ) );
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
	$hero_slant_deg = max( -30, min( 30, $hero_slant_deg ) );
	$footer_slant_deg = max( -30, min( 30, $footer_slant_deg ) );
	$hero_content_width = max( 420, min( 1600, $hero_content_width ) );
	$hero_title_size = max( 3.0, min( 10.0, $hero_title_size ) );
	$hero_subtitle_size = max( 1.0, min( 6.0, $hero_subtitle_size ) );
	$footer_title_width = max( 320, min( 1200, $footer_title_width ) );
	$footer_title_size = max( 1.6, min( 6.0, $footer_title_size ) );
	$hero_overlay_angle = $hero_overlay_direction === 'ltr' ? '270deg' : '90deg';
	$hero_slant_pct = round( ( abs( $hero_slant_deg ) / 30 ) * 18, 2 );
	$hero_slant_left_pct = $hero_slant_deg < 0 ? $hero_slant_pct : 0;
	$hero_slant_right_pct = $hero_slant_deg > 0 ? $hero_slant_pct : 0;
	$hero_slant_left = $hero_slant_left_pct . '%';
	$hero_slant_right = $hero_slant_right_pct . '%';
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
		'--hero-slant-left:' . $hero_slant_left . ';' .
		'--hero-slant-right:' . $hero_slant_right . ';' .
		'--footer-slant-left:' . $footer_slant_left . ';' .
		'--footer-slant-right:' . $footer_slant_right . ';' .
		'--hero-content-width:' . $hero_content_width . 'px;' .
		'--hero-title-size:' . $hero_title_size . 'rem;' .
		'--hero-subtitle-size:' . $hero_subtitle_size . 'rem;' .
		'--footer-title-width:' . $footer_title_width . 'px;' .
		'--footer-title-size:' . $footer_title_size . 'rem;' .
		'}';

	// Title border toggle
	$title_border_enabled = absint( get_theme_mod( 'upaif_title_border_enabled', 1 ) );
	if ( ! $title_border_enabled ) {
		$css .= '.upaif-post-title{border-left:none;padding-left:0;}';
	}

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
			'transport' => 'postMessage',
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
			'transport' => 'postMessage',
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
			'label' => 'Hero title',
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
			'label' => 'Hero subtitle',
			'section' => 'upaif_header',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_height_vh',
		array(
			'default' => 60,
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_height_vh',
		array(
			'label' => 'Hero height (vh)',
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
			'default' => 0,
			'sanitize_callback' => 'upaif_sanitize_int',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_slant_deg',
		array(
			'label' => 'Hero slant angle',
			'section' => 'upaif_header',
			'type' => 'range',
			'input_attrs' => array(
				'min' => -30,
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
			'label' => 'Hero overlay fade direction',
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
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_content_width_px',
		array(
			'label' => 'Hero content width (px)',
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
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_title_size_rem',
		array(
			'label' => 'Hero title size (rem)',
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
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_subtitle_size_rem',
		array(
			'label' => 'Hero tagline size (rem)',
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
		'upaif_hero_cta_text',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_cta_text',
		array(
			'label' => 'Hero button text',
			'description' => __( 'Leave empty to hide', 'upaif' ),
			'section' => 'upaif_header',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'upaif_hero_cta_url',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'upaif_hero_cta_url',
		array(
			'label' => 'Hero button URL',
			'section' => 'upaif_header',
			'type' => 'url',
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
			'label' => 'Hero text alignment',
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
		'upaif_title_border_enabled',
		array(
			'default' => 1,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'upaif_title_border_enabled',
		array(
			'label' => __( 'Show title left border', 'upaif' ),
			'description' => __( 'Red accent border on post titles', 'upaif' ),
			'section' => 'upaif_theme',
			'type' => 'checkbox',
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
		'upaif_footer_cta_url',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'upaif_footer_cta_url',
		array(
			'label' => __( 'Footer CTA link URL', 'upaif' ),
			'description' => __( 'Leave empty for no link', 'upaif' ),
			'section' => 'upaif_footer',
			'type' => 'url',
		)
	);

	$wp_customize->add_setting(
		'upaif_footer_slant_deg',
		array(
			'default' => 0,
			'sanitize_callback' => 'upaif_sanitize_int',
			'transport' => 'postMessage',
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
			'transport' => 'postMessage',
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
			'transport' => 'postMessage',
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
			'transport' => 'postMessage',
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
			'transport' => 'postMessage',
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

/**
 * Enqueue Customizer live preview script.
 */
function upaif_customizer_preview_js() {
	wp_enqueue_script(
		'upaif-customizer-preview',
		get_template_directory_uri() . '/customizer-preview.js',
		array( 'customize-preview', 'jquery' ),
		filemtime( get_template_directory() . '/customizer-preview.js' ),
		true
	);
}
add_action( 'customize_preview_init', 'upaif_customizer_preview_js' );
