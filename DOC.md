DOC.md – Uppsala Pole & Aerials (UPAIF) – Phase 1 – Final Coding Brief
Theme folder
upaif/
Theme header / name
Uppsala Pole & Aerials

** Core rules: **

Starter: Underscores (_s)

No ACF, no page builders → custom meta boxes + Gutenberg blocks
Custom blocks preferred for reusable content (slider + modules)
Use WordPress native menu system (Appearance → Menus) — no hardcoded nav
Contact Form 7 for all forms

Calendar/booking/payments/emails = phase 2+
Light Open Graph + basic schema.org (Event, Person, LocalBusiness where natural)
Mobile-first, standard breakpoints (≈576 / 768 / 992 / 1200)
Semantic HTML + basic ARIA (nice-to-have)
Icons: use appropriate lightweight library (e.g. Feather, Line Awesome, or Font Awesome free) — decide during styling

Page structure & slugs (Swedish)

Home: /hem (static front page)
Classes & Booking: /klasser
Instructors: /larare
News / Blog: /nyheter
Contact: /kontakt

Custom Post Types

slide
title, featured image, editor (optional)
meta: subtitle, cta_text, cta_url, overlay_color, overlay_opacity

instructor
title, editor, featured image
meta: role, short_bio, instagram_url, facebook_url, tiktok_url

class
title, editor, featured image, excerpt
meta: level (select: Nybörjare, Medel, Avancerad, Alla nivåer), duration, price_info (text), video_embed_url (optional)
taxonomy: class-type (non-hierarchical)


Taxonomy

class-type
Terms (pre-registered):
Pole, Aerial hoop, Flow, Stretch, Open Practise, Kursavslutning / Öppen scen, Youngsters, Extraklasser, Presentkort


Templates (priority order)

front-page.php
page.php (fallback for all pages)
archive.php / index.php (news archive)
single.php (news single)
single-class.php
archive-class.php (optional – list view of classes)
taxonomy-class-type.php (optional – per type archive)
page-larare.php (instructors grid page)
single-instructor.php (optional – detail view)
Standard: 404, search

Custom Gutenberg Blocks (to register)

UPAIF Slider (container)
Inner blocks: only UPAIF Slide
Attributes: autoplay (bool), delay (s), arrows (bool), dots (bool), effect (slide/fade)

UPAIF Slide (inner block)
image, title, subtitle, cta_text, cta_url, overlay settings

UPAIF Instructor Grid
columns (2–4), number of items or manual selection

UPAIF Instructor Card (single reusable)
UPAIF CTA Banner
bg image/color, headline, text, button

UPAIF Text + Image (two-column alternating)

Frontend Slider

Library: Swiper.js (lightweight, modern)
Enqueue only where used (conditional)
Autoplay, arrows, dots — all configurable via block settings

Other
If decision to use WooCommerce for booking and payments, leave open to do so. WooCommerce is a memory hog so if we can create our own booking and payment system, that would be preferred.

Navigation
Use wp_nav_menu() with theme_location = 'primary'
(admin creates menu in WP admin → Appearance → Menus)

Hero slider
Reusable block → mainly used on /hem but can be placed anywhere

Instructors page (/instruktorer)
Simple grid using UPAIF Instructor Grid block (no single pages yet unless needed later)

Presentkort
Treated as regular class CPT entry (product-like info only, no e-commerce in phase 1)

Social sharing
Basic og:title, og:description, og:image (featured image fallback), twitter:card

Customizer
Logo, footer copyright, social links (global), color swatches for common theming elements