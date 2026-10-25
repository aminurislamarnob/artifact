# AGENTS.md

Instructions and guidelines for AI coding agents operating on the **Artifact** WordPress block theme.

## Repository Overview
- **Theme**: Artifact (Full Site Editing block theme for company websites).
- **Target**: Official WordPress.org Theme Directory submission.
- **Requirements**: WordPress 6.9+, PHP 7.4+.
- **Configuration**: `theme.json` (schema v3).
- **Text Domain**: `artifact`, domain path `/languages`.
- **Design**: Figma `rhXpPSv3HxiGpTiN733snB`, Homepage dark (node `9100:115184`) Services list page (node `9153:182157`), Service Details page (node `9153:182446`) and About page (node `9146:115186`). Other pages wait for their frames.
- **Pages**: non-front pages ship as starter page patterns plus a custom template (`page-no-title`, or `page-service-details` for each service, a child page of Services), not as slug templates. Template text lives in hidden patterns.

## Local Theme Review Agent
This repository contains a dedicated repo-specific review agent and skill:
- **Subagent / Skill Name**: `wp-theme-reviewer`
- **Definition Path**: `.agents/agents/wp-theme-reviewer/agent.md`
- **Skill Path**: `.agents/skills/wp-theme-reviewer/SKILL.md`

Whenever changes are made, run the review suite to guarantee WordPress.org submission readiness:
```bash
composer test:unit        # theme standards, presets, patterns & licensing
composer test:integration # template hierarchy & rendering
npm run test:e2e          # Playwright + axe WCAG 2.1 A/AA, keyboard, mobile & editor
wp theme-check run artifact # Official WordPress.org Theme Check plugin scan
bash .agents/skills/wp-theme-reviewer/scripts/theme-unit-test.sh verify # Theme Unit Test data audit
```

## WordPress.org Compliance Rules
1. **Licensing**:
   - 100% GPL-compatible license.
   - Fonts must be self-hosted in `assets/fonts/` with `OFL.txt`. Zero Google Fonts CDN calls.
   - Images must be CC0, CC BY 4.0, or author's original artwork (GPL).
   - Icons are Material Symbols (Apache 2.0), credited by file in `readme.txt`. Figma layers named `fi_<number>` are Flaticon downloads and must not be exported.
   - **Strictly Prohibited**: Third-party non-GPL stock photo services and commercial asset repositories with redistribution or compilation restrictions.
2. **Security & Escaping**:
   - Zero raw echoes in PHP files.
   - Between HTML tags: `esc_html__()` / `esc_html()`.
   - HTML attributes: `esc_attr__()` / `esc_attr()`.
   - URLs: `esc_url()`.
   - Formatting markup: `wp_kses_post()`.
   - All custom functions and variables must be prefixed with `artifact_`.
3. **Plugin Territory**:
   - No Custom Post Types (CPTs), taxonomies, custom blocks, or shortcodes in the theme.
   - Block styles belong in `styles/blocks/`. Patterns belong in `patterns/`.
4. **Branding**:
   - Always spell "WordPress" with a capital "P".
