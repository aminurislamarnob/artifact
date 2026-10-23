# CLAUDE.md

Artifact is a WordPress block theme (full site editing) for company websites, aimed at WordPress.org. Default look is black. Requires WordPress 6.7+ and PHP 7.4+. `theme.json` schema version 3. Text domain `artifact`, domain path `/languages`.

Local site: `http://fse-theme-dev.test` (Herd root `/Users/aiarnob/Herd/fse-theme-dev`). No build step. Activate the theme and load the site.

## Scope

Design source is Figma `rhXpPSv3HxiGpTiN733snB`, Homepage dark only (node `9100:115184`). Sample fills; do not trust typed hex labels. Do not invent other pages until those frames exist. No WooCommerce. No theme style variations. LTR only: do not add `accessibility-ready`, `rtl-language-support`, or e-commerce tags. Still ship a skip link and keyboard-usable nav.

## Architecture

`theme.json` is the only token source. Patterns, parts, and templates consume presets (`var(--wp--preset--…)` or `var:preset|…`). Do not copy hex or px into PHP or ad-hoc CSS.

- `functions.php` loads the text domain only. Do not register block styles in PHP, and do not re-add supports core already gives block themes.
- `templates/front-page.html` is `wp:pattern` references. Section bodies are `patterns/*.php`. Header and footer are `parts/header.html` and `parts/footer.html`.
- `page`, `single`, `archive`, `search`, `404`, and `index` are generic: header, main, footer, and core query/post blocks.
- Block style variations are JSON in `styles/blocks/` (files with `blockTypes`). No theme style variation JSON.
- `style.css` is the theme header. Prefer `theme.json` over a CSS dump.
- Fonts are self-hosted Poppins WOFF2. No TTF, no font CDN.
- Photos that are not clearly licensed are bundled Unsplash files, with source URL and licence in `readme.txt`. No remote images or scripts at runtime.
- No theme JavaScript unless a homepage section cannot be done with core blocks and CSS.

## Tokens

Keep these slugs. `main-bg` is the page surface. Use primary as text only where contrast meets AA. Add a slug only when a colour cannot map.

- Colors: `primary`, `secondary`, `main-bg`, `light-bg`, `dark-bg`, `heading-color`, `text-white`, `text-color`, `link-color`
- Font sizes: `small|medium|large-paragraph`, `small|medium|large-title`, `heading-01`…`heading-06`, `button-large`, `button-small`
- Spacing: `10`, `20`, `30`, `50`, `60`, `70`, `100`
- Font family: `poppins`

`appearanceTools` and `useRootPaddingAwareAlignments` are on. Core default palette, gradients, duotone, spacing sizes, and font sizes are off.

## theme.json cache

WordPress caches compiled global styles. If an edit does not show, hard-refresh. Site Editor customizations in `wp_global_styles` override `theme.json`.

## Tests

`composer test:unit` (files only), `composer test:integration` (needs the `artifact_tests` MySQL database, which it wipes), `npm run test:e2e` (needs Artifact active on `WP_BASE_URL`, default `http://fse-theme-dev.test`). When you add a token slug, pattern or template, update the expected lists in `tests/phpunit/unit` so the suite keeps guarding the contract. See `README.md` for setup.

