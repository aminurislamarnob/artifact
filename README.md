# Artifact

WordPress block theme for company websites. Default look is black (dark surfaces, light text).

See `readme.txt` for installation, changelog, and bundled resource licences. Translation template: `languages/artifact.pot`.

## Tests

Tooling only; none of it ships (see `.distignore`).

**PHPUnit** (`composer install` first)

- `composer test:unit` reads the theme files from disk: `theme.json` tokens and contrast, `style.css`/readme metadata, pattern headers and escaping, preset slugs used by markup, no remote URLs/hex colours/JS, POT coverage. No WordPress or database needed.
- `composer test:integration` loads WordPress through `wp-phpunit` with Artifact active: theme.json resolution, pattern registration and rendering (including hostile translations), template routing, and full rendered pages (landmarks, skip link, headings).
  It needs MySQL and a throwaway database, which the test suite **wipes**: `artifact_tests` by default (the config refuses names without "test"). The theme must live in a WordPress install's `wp-content/themes`; the install is found automatically, or set `WP_CORE_DIR`. Other overrides: `WP_TESTS_DB_NAME`, `WP_TESTS_DB_USER`, `WP_TESTS_DB_PASSWORD`, `WP_TESTS_DB_HOST`.

**Playwright** (`npm install && npx playwright install chromium` first)

- `npm run test:e2e` drives a real site with Artifact active: homepage content and computed design tokens, generic templates, comments, search, 404, keyboard access, axe WCAG scans, the mobile menu, and block validity of every pattern in the block and site editors.
- Defaults to the Herd site `https://woocommerce.test` at `~/Herd/woocommerce`. Override with `WP_BASE_URL` (also passed to WP-CLI as `--url`), `WP_PATH` (same install, used by WP-CLI) and `WP_CLI_BIN`. Runs 1 worker, since Herd returns 502s under parallel load. Global setup creates and afterwards deletes its own posts, page, category and administrator.

