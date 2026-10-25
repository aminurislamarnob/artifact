# CLAUDE.md

Artifact is a WordPress block theme (full site editing) for company websites, aimed at WordPress.org. Default look is black. Requires WordPress 6.9+ (the work process section uses `core/accordion`) and PHP 7.4+. `theme.json` schema version 3. Text domain `artifact`, domain path `/languages`.

Local site: `http://fse-theme-dev.test` (Herd root `/Users/aiarnob/Herd/fse-theme-dev`, whose `wp-content/themes/artifact` symlinks to this repo). No build step. Activate the theme and load the site.

## Scope

Design source is Figma `rhXpPSv3HxiGpTiN733snB`: Homepage dark (node `9100:115184`), the Services list page (node `9153:182157`), the Service Details page (node `9153:182446`), the About page (node `9146:115186`), the Portfolio page (node `4300:79702`), and the Portfolio Details page (node `4307:127482`). The two portfolio frames are light; build them in the theme's dark look. Sample fills; do not trust typed hex labels or layer text. Do not invent other pages until those frames exist. No WooCommerce support. No theme style variations. LTR only: do not add `accessibility-ready`, `rtl-language-support`, or e-commerce tags. Still ship a skip link and keyboard-usable nav.

## Architecture

`theme.json` is the only token source. Patterns, parts, and templates consume presets (`var(--wp--preset--…)` or `var:preset|…`). Do not copy hex into markup or CSS.

- `functions.php` loads the text domain and filters `hooked_block_types` so WooCommerce's mini cart and account blocks stay out of the header. Nothing else: no block style registration, no supports core already gives block themes.
- `templates/front-page.html` is a `<main>` of `wp:pattern` references in order: hero, features, about, fun-facts, services, a wide separator, work-process, team, testimonials, latest-articles, project-cta.
- `parts/header.html` and `parts/footer.html` only reference `artifact/header` and `artifact/footer`. Those patterns hold the markup, are bound to their template part areas, and have `Inserter: no`.
- The header menu is an empty `<!-- wp:navigation /-->`, so core shows the site's newest saved menu or its pages. Do not hard-code menu links. The current page link (`aria-current="page"`) is primary-coloured.
- Pages other than the front page ship as starter page patterns (`Block Types: core/post-content`, `Post Types: page, wp_template`) built from section patterns, plus the `page-no-title` custom template (header, `post-content`, footer) so the pattern can supply the H1. `artifact/page-services` is page-hero, services-grid, a wide separator, work-process, a wide separator, project-cta. `artifact/page-about` is page-hero, a team photo, brands, values, fun-facts-grid, a wide separator, team, a wide separator, project-cta; its client names are text, not logos, so users can swap in their own. `artifact/page-portfolio` is page-hero, portfolio-grid (eight cards in alternating wide and narrow rows; only the title links), a wide separator, project-cta. `artifact/page-hero` labels the page with a `post-title` block at `level: 0`.
- Repeatable page types get a custom template for structure plus a starter pattern for the body, like Twenty Twenty-Five. Each service is a child page of Services using the `page-service-details` template: header, `artifact/hidden-service-hero` ("Service Details" label and the page title as the H1), `post-content` (full width, `spacing|20` side padding), a wide separator, `artifact/project-cta`, footer. `artifact/page-service-details` is the body: intro, photo, approach, features and problems, two photos, deliverables, next steps. Each project is a child page of Portfolio using the `page-portfolio-details` template: header, `post-content` (full width, `spacing|20` side padding), a wide separator, `artifact/project-cta`, footer. Its facts (category, client, date, location) differ per project, so `artifact/page-portfolio-details` carries the whole hero (a `post-title` at `level: 1`, an introduction and the facts) followed by a photo, about, challenges and solutions, two photos, process and results. Text a template shows goes in a hidden pattern, never in the HTML.
- `index`, `archive`, and `search` are main-query loops (blog cards with featured image, author avatar, date, time to read) with pagination and the hidden `artifact/hidden-no-results` pattern. `404` uses `artifact/hidden-404` with a search. `single` has title, meta, featured image, content, terms, a two-post latest articles query, and threaded, paginated comments. `page` is title and content.
- Hidden patterns are named `hidden-*.php` and have `Inserter: no`. Every other pattern uses core pattern categories (`services`, `banner`, `featured`, …); do not register theme categories.
- Card links with repeated text ("Learn More") carry a `screen-reader-text` span naming their target, so link names are unique.
- Theme CSS lives in `theme.json` `styles.css`, scoped to `artifact-*` classes and core block classes (post content, comments, query pagination, forms). It uses presets and `rgba()`, never hex. Breakpoints are 1024px, 781px, and 600px. Respect `prefers-reduced-motion`. Blog article typography (`.wp-block-post-content`, `.entry-content`) is wrapped in `:where(body:not(.page-template-page-no-title):not(.page-template-page-service-details):not(.page-template-page-portfolio-details))` so it never restyles pattern-built pages. Add new pattern-built page templates to that list.
- Block style variations are JSON in `styles/blocks/` (files with `blockTypes`, currently `button-rounded.json`). No theme style variation JSON.
- `style.css` is the theme header only, with no rules.
- Fonts are self-hosted Poppins WOFF2 (400, 500, 600, 700) in `assets/fonts/` with `OFL.txt`. No TTF, no font CDN.
- Images in `assets/images/` are original artwork and Figma exports (GPL as part of the theme). Every icon (`icon-*.svg`, `stars-rating.svg`) is a Material Symbol (Apache 2.0) listed by file and symbol name in the `readme.txt` Material Symbols entry. Figma icon layers named `fi_<number>` are Flaticon downloads: never export them. Photos the design shows without a licence are replaced with CC0 photos (StockSnap, `service-*.jpg`, `company-*.jpg` and `portfolio-*.jpg`), each credited with its page URL in `readme.txt`. Do not use Unsplash, Pixabay, Freepik, Flaticon, Shutterstock, or other non-GPL asset services. No remote images or scripts at runtime.
- No theme JavaScript. Interactive sections use core blocks (the accordion uses core's own script) and CSS.
- `.distignore` keeps dev files (`.agents`, `.claude`, `tests`, configs, `CLAUDE.md`, `AGENTS.md`, `README.md`) out of the release zip.

## WordPress.org rules

- Escape all PHP output: `esc_html__()`/`esc_html()` between tags, `esc_attr__()`/`esc_attr()` in attributes, `esc_url()` for URLs, `wp_kses_post()` for translatable markup. No raw echoes.
- Every translatable string uses the `artifact` text domain and must be in `languages/artifact.pot`. Regenerate it with `wp i18n make-pot . languages/artifact.pot`.
- Prefix functions, constants, handles, image sizes, and custom CSS classes with `artifact_` or `artifact-`.
- Plugin territory is off limits: no custom post types, taxonomies, custom blocks, shortcodes, or roles. Do not remove core hooks or hide the admin bar.
- Spell "WordPress" with a capital P.

## Tokens

Keep these slugs. `main-bg` is the page surface. Use primary as text only where contrast meets AA. Add a slug only when a colour cannot map.

- Colors: `primary`, `secondary`, `main-bg`, `light-bg`, `dark-bg`, `heading-color`, `text-white`, `text-color`, `link-color`, `border`
- Font sizes: `small|medium|large-paragraph`, `small|medium|large-title`, `heading-01`…`heading-06`, `button-large`, `button-small`
- Spacing: `10`, `20`, `30`, `50`, `60`, `70`, `100`
- Font family: `poppins`
- Layout: `contentSize` 800px, `wideSize` 1170px

`appearanceTools` and `useRootPaddingAwareAlignments` are on. Core default palette, gradients, duotone, spacing sizes, and font sizes are off.

## theme.json cache

WordPress caches compiled global styles. If an edit does not show, hard-refresh. Site Editor customizations in `wp_global_styles` override `theme.json`.

## Tests

`composer test:unit` (files only), `composer test:integration` (needs the `artifact_tests` MySQL database, which it wipes), `npm run test:e2e` (Playwright and axe-core; needs Artifact active on `WP_BASE_URL`, default `http://fse-theme-dev.test`, and `WP_PATH` for WP-CLI). E2E global setup creates and then deletes its own posts, pages (one built from `artifact/page-services`, one from `artifact/page-about`, one from `artifact/page-portfolio`, a child service using the Service Details template, and a child project using the Portfolio Details template), category, administrator, and a navigation menu, which the header shows because it is the newest. When you add a token slug, pattern or template, update the expected lists in `tests/phpunit/unit` so the suite keeps guarding the contract. See `README.md` for setup.

Also run `wp theme-check run artifact` (Theme Check plugin) and `bash .claude/skills/wp-theme-reviewer/scripts/theme-unit-test.sh verify` (Theme Unit Test settings and endpoints). The script's `import` and `settings` commands change the site's options, permalinks, and plugins, so ask first.

## Review agent

For a WordPress.org submission audit, use the `wp-theme-reviewer` subagent (`.claude/agents/wp-theme-reviewer.md`) or skill (`.claude/skills/wp-theme-reviewer/SKILL.md`). The Gemini copies live in `.agents/`. Keep both in sync.
