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

## Key WordPress.org Theme Review Policies
1. **Queue Limit**: Only 1 theme per author in the queue at any time.
2. **Rejection Threshold**: $\ge 3$ distinct required issues result in immediate closure/rejection.
3. **Inactivity Rule**: 7 days without response closes the ticket.
4. **Licensing**: All code, fonts, and images must be 100% GPL-compatible. Fonts must be self-hosted with `OFL.txt`. Unsplash, Pixabay, and Freepik are strictly prohibited.
5. **Security**: All output must be properly escaped (`esc_html__`, `esc_attr__`, `esc_url`, `wp_kses_post`).
