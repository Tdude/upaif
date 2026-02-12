/**
 * UPAIF Theme Customizer Live Preview
 * Updates CSS variables in real-time when Customizer settings change.
 */
(function($) {
  'use strict';

  // Helper: update a CSS variable on :root
  function setCSSVar(name, value) {
    document.documentElement.style.setProperty(name, value);
  }

  // Footer background color
  wp.customize('upaif_footer_bg_color', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--footer-bg', newVal);
    });
  });

  // Footer text color
  wp.customize('upaif_footer_text_color', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--footer-text', newVal);
    });
  });

  // Footer slant angle
  wp.customize('upaif_footer_slant_deg', function(value) {
    value.bind(function(newVal) {
      var deg = parseInt(newVal, 10) || 0;
      deg = Math.max(-30, Math.min(30, deg));
      var pct = Math.round((Math.abs(deg) / 30) * 18 * 100) / 100;
      var leftPct = deg < 0 ? pct + '%' : '0%';
      var rightPct = deg > 0 ? pct + '%' : '0%';
      setCSSVar('--footer-slant-left', leftPct);
      setCSSVar('--footer-slant-right', rightPct);
    });
  });

  // Footer title width
  wp.customize('upaif_footer_title_width_px', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--footer-title-width', newVal + 'px');
    });
  });

  // Footer title size
  wp.customize('upaif_footer_title_size_rem', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--footer-title-size', newVal + 'rem');
    });
  });

  // Hero slant angle
  wp.customize('upaif_hero_slant_deg', function(value) {
    value.bind(function(newVal) {
      var deg = parseInt(newVal, 10) || 0;
      deg = Math.max(0, Math.min(30, deg));
      var pct = Math.round((deg / 30) * 18 * 100) / 100;
      setCSSVar('--hero-slant-pct', pct);
    });
  });

  // Hero height (note: setting name is upaif_hero_height_vh)
  wp.customize('upaif_hero_height_vh', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--hero-height', newVal + 'vh');
    });
  });

  // Hero content width
  wp.customize('upaif_hero_content_width_px', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--hero-content-width', newVal + 'px');
    });
  });

  // Hero title size
  wp.customize('upaif_hero_title_size_rem', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--hero-title-size', newVal + 'rem');
    });
  });

  // Hero subtitle size
  wp.customize('upaif_hero_subtitle_size_rem', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--hero-subtitle-size', newVal + 'rem');
    });
  });

  // Header background start (note: setting name ends with _color)
  wp.customize('upaif_header_bg_start_color', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--header-bg-start', newVal);
    });
  });

  // Header background end (note: setting name ends with _color)
  wp.customize('upaif_header_bg_end_color', function(value) {
    value.bind(function(newVal) {
      setCSSVar('--header-bg-end', newVal);
    });
  });

})(jQuery);
