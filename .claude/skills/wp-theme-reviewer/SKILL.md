---
name: wp-theme-reviewer
description: Official WordPress.org theme review agent for the Artifact FSE theme. Use when reviewing the theme against the official WordPress Theme Review Handbook, block theme requirements, Theme Unit Test cases, Theme Check plugin validations, GPL licensing, and security guidelines.
---

# WordPress.org Theme Reviewer (Artifact FSE)

This repository-specific skill provides instructions and test execution procedures to audit and review the **Artifact** WordPress Full Site Editing (FSE) block theme according to the official [WordPress.org Theme Review Handbook](https://make.wordpress.org/themes/handbook/review/).

## Review Workflow Steps

### Step 1: Run PHPUnit Unit Tests
```bash
composer test:unit
```
Verifies theme file contracts, theme presets against `theme.json`, template pattern references, license declarations in `readme.txt`, and ensures zero prohibited non-GPL image repositories are referenced.

### Step 2: Run PHPUnit Integration Tests
```bash
composer test:integration
```
Verifies WordPress core integration, template rendering, and text domain loading.

### Step 3: Run Playwright E2E & Accessibility Tests
```bash
npm run test:e2e
```
Executes 68 end-to-end tests covering:
- WCAG 2.1 A/AA scans via Axe-core
- Keyboard navigation & tab order
- Skip link targeting `<main>`
- Responsive mobile viewports (375px)
- Block editor block validation for all 14 patterns

### Step 4: Run Official Theme Check
```bash
wp theme-check run artifact
```
Runs the official WordPress.org Theme Check plugin to detect any required violations or warnings.

### Step 5: Check Translation File
```bash
wp i18n make-pot . languages/artifact.pot
```
Ensures all translatable strings are captured and text domain is `artifact`.

### Step 6: Theme Unit Test Data & Settings
The official WordPress Theme Unit Test data populates WordPress with stub data (edge cases, long titles, sticky posts, media alignments, threaded comments, empty titles/bodies) to verify visual rendering under review conditions.

To download the official test XML, install `wordpress-importer`, import stub data, and configure the 6 required handbook settings:
```bash
bash .claude/skills/wp-theme-reviewer/scripts/theme-unit-test.sh import
```

To audit active test settings and critical endpoints:
```bash
bash .claude/skills/wp-theme-reviewer/scripts/theme-unit-test.sh verify
```

To re-apply official handbook settings only (e.g. `posts_per_page=5`, `thread_comments_depth=3`, permalinks):
```bash
bash .claude/skills/wp-theme-reviewer/scripts/theme-unit-test.sh settings
```

`import` and `settings` change the active site's options, permalinks, and plugins. Confirm with the user before running them.

## Key WordPress.org Theme Review Policies
1. **Queue Limit**: Only 1 theme per author in the queue at any time.
2. **Rejection Threshold**: 3 or more distinct required issues result in immediate closure/rejection.
3. **Inactivity Rule**: 7 days without response closes the ticket.
4. **Licensing**: All code, fonts, and images must be 100% GPL-compatible. Fonts must be self-hosted with `OFL.txt`. Third-party non-GPL stock photo services and commercial asset repositories are strictly prohibited.
5. **Security**: All output must be properly escaped (`esc_html__`, `esc_attr__`, `esc_url`, `wp_kses_post`).
