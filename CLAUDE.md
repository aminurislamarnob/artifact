# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Artifact — a WordPress **block theme** (full site editing) for company websites, being built for **WordPress.org submission**. Default look is **black** (dark surfaces, light text). It lives inside a local WordPress install served by Laravel Herd at `/Users/aiarnob/Herd/fse-theme-dev` (site root is the parent of `wp-content`).

**Branch:** `black-theme` (from `0cd565b`) is the development line and is intended to become the default branch. Do not go back to `develop` for this work. One theme, this directory.

**Rebrand:** product is **Artifact** (`text domain: artifact`, `Domain Path: /languages`). Do not keep a Blockspire slug.

**Design source of truth:** Figma file `rhXpPSv3HxiGpTiN733snB` (`Welabs-Website--Copy-`). First implementation is **Homepage dark** only (file URL node `9100:115184`; share token `bAeVocykPcNyLmXN-0`). Do not invent other pages. Other screens wait until the Figma file is updated. Sample real fills; do not trust typed hex labels. The old light file `JKkrAuUfQemwOIXPDfS3Y2` is not in scope on this branch.

**WooCommerce:** out of scope for this first pass. No `add_theme_support( 'woocommerce' )`, no product templates, until shop frames exist in Figma.

**Requires:** WordPress 6.7+ / PHP 7.4+. `theme.json` schema version 3.

**WordPress.org:** follow block-theme handbook practice so the theme can pass review: tokens only in `theme.json`, block style variations as JSON in `styles/blocks/` (never `register_block_style()` + inline CSS), no remote requests, bundled assets with sources in `readme.txt`, translatable strings, RTL-safe CSS. **Do not add the `accessibility-ready` tag** for v1. Still ship a skip link and keyboard-usable nav because theme review requires those even without the tag.

**Media:** Use Figma **custom** assets (icon SVG, shapes, decorative vectors). Do not copy Figma photos unless the licence is clear. If a photograph is not clearly free, **download a free Unsplash photo, bundle it locally**, and record source URL + licence in `readme.txt`. Never hotlink Unsplash or Figma at runtime.

**Style variations:** default black only. No theme style variation files until a second designed look exists.

**Direction:** LTR only for v1. No `rtl-language-support` tag.

**Homepage composition:** `templates/front-page.html` is a list of `wp:pattern` refs; section bodies live in `patterns/*.php`; chrome in `parts/header.html` and `parts/footer.html`.

**Inner templates:** ship generic `page`, `single`, `archive`, `search`, and `404` (header/footer + core query/post blocks, `theme.json` styles only). Do not invent Figma layouts for them until those screens exist.

**Grill / plan one question at a time.** Ask a single numbered question, give the recommended answer, then wait. Do not batch questions. Word the question so “yes” accepts the recommendation.

**Implementation:** the plan above is locked. Build against it; do not reopen settled forks unless the user changes them.

There is **no build step**: no `package.json`, no `composer.json`, no bundler, no test suite. Files are edited and served directly. "Running" the theme means loading the site in the browser and activating the theme; there is nothing to compile.

## Architecture

Everything about the theme's design system lives in `theme.json`. It is the single source of truth — `functions.php` and templates consume it, never duplicate it.

- **`theme.json`** (schema v3) defines the entire token set: color palette, font sizes, spacing sizes, the self-hosted Poppins family (four weights, **WOFF2**, via `fontFace`), and `styles` for elements/blocks. Core default palette, gradients, duotone, and default spacing sizes are all **disabled** — only the theme's own presets are offered in the editor. Convert the existing TTFs to WOFF2 and do not ship TTF or any font CDN. If Homepage dark clearly uses another family, switch then; until then Poppins is the family.
- **`functions.php`** stays thin: load the text domain. Do not register block styles in PHP. Block themes already get `post-thumbnails`, `responsive-embeds`, `editor-styles`, `html5` and `automatic-feed-links` from core — never re-add those. **No theme JavaScript** in this pass unless a Homepage dark section cannot be done with core blocks and CSS.
- **`styles/`** JSON partials: a file **with** `blockTypes` is a block style variation; one **without** is a theme style variation. Core scans this directory recursively. **No theme style variations** in this pass (no extra palettes under `styles/*.json`). `styles/blocks/` only for block styles Homepage dark actually uses.
- **`style.css`** is the theme header only (metadata). Do not put rules there unless a later pass truly needs a specificity escape hatch (focus, plugin CSS). Prefer theme.json.
- **`templates/front-page.html`** composes Homepage dark as `wp:pattern` references only. Each section is a PHP pattern in `patterns/` (translatable strings). Header and footer are template parts (`parts/header.html`, `parts/footer.html`) sourced from that homepage chrome. `index.html` is a minimal fallback so the theme activates. Do not invent About/Blog/Shop pages until those Figma screens exist.

### Token naming conventions

Keep these **slugs**; **values** come from sampled Homepage dark fills (never typed Figma hex labels). `main-bg` is the black page surface. Primary/accent are used only where contrast meets AA. Add a slug only when the homepage uses a colour that cannot map.

Presets are referenced in CSS as `var(--wp--preset--<type>--<slug>)`. Established slugs:

- Colors: `primary`, `secondary`, `main-bg`, `light-bg`, `dark-bg`, `heading-color`, `text-white`, `text-color`, `link-color`
- Font sizes: `small|medium|large-paragraph`, `small|medium|large-title`, `heading-01`…`heading-06`, `button-large`, `button-small`
- Spacing: numeric slugs matching the px value (`10`, `20`, `30`, `50`, `60`, `70`, `100`)
- Font family: `poppins` (WOFF2, self-hosted)

Never duplicate token values in PHP or in ad-hoc CSS. Reference presets (`var(--wp--preset--<type>--<slug>)`) or `var:preset|…` in block attributes.

### Conventions

- **Grill / plan one question at a time** (see above).
- Text domain is **`artifact`**. Wrap user-facing strings in translation functions with that domain. Domain path is `/languages`.
- Do not add the `accessibility-ready` tag in v1.
- Every bundled image: source URL and licence in `readme.txt`. Figma custom SVG/shapes are fine. Photos: Unsplash (bundled, not hotlinked) if the Figma bitmap is not clearly free.
- No `assets/js/` until a homepage section proves it needs script.
- No theme style variation JSON in this pass.
- **LTR only for v1.** Do not add the `rtl-language-support` tag. Do not spend this pass on RTL mirroring.
- Theme requires **WP 6.7+ / PHP 7.4+**. Keep API usage within that floor. `theme.json` stays schema version 3. Do not claim Requires at least 6.2.
- Fonts: self-hosted Poppins **WOFF2** only. No remote fonts. No TTF in the zip.
- `useRootPaddingAwareAlignments` and `appearanceTools` are on — prefer layout/alignment via theme.json settings over hand-written CSS.

### Editing theme.json

Changes to `theme.json` may not appear immediately: WordPress caches the compiled global styles. If a change doesn't show up, check that the site is not in production mode and hard-refresh / flush caches. Site Editor customizations saved by a user are stored in the database (`wp_global_styles`) and **override** `theme.json` — a "my change isn't applying" report is usually this, not a syntax error.
