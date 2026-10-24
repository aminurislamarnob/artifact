# AGENTS.md

Instructions and guidelines for AI coding agents operating on the **Artifact** WordPress block theme.

## Repository Overview
- **Theme**: Artifact (Full Site Editing block theme for company websites).
- **Target**: Official WordPress.org Theme Directory submission.
- **Requirements**: WordPress 6.7+, PHP 7.4+.
- **Configuration**: `theme.json` (schema v3).
- **Text Domain**: `artifact`, domain path `/languages`.

## Local Theme Review Agent
This repository contains a dedicated repo-specific review agent and skill:
- **Subagent / Skill Name**: `wp-theme-reviewer`
- **Definition Path**: `.agents/agents/wp-theme-reviewer/agent.md`
- **Skill Path**: `.agents/skills/wp-theme-reviewer/SKILL.md`

Whenever changes are made, run the review suite to guarantee WordPress.org submission readiness:
```bash
composer test:unit        # 292 assertions checking theme standards & presets
composer test:integration # 161 assertions verifying template hierarchy & rendering
npm run test:e2e          # 68 Playwright tests verifying Axe WCAG 2.1 A/AA, a11y, mobile & editor
wp theme-check run artifact # Official WordPress.org Theme Check plugin scan
```

## WordPress.org Compliance Rules
1. **Licensing**:
   - 100% GPL-compatible license.
   - Fonts must be self-hosted in `assets/fonts/` with `OFL.txt`. Zero Google Fonts CDN calls.
   - Images must be CC0, CC BY 4.0, or author's original artwork (GPL).
   - **Strictly Prohibited**: `unsplash.com`, `pixabay.com`, `freepik.com`, `flaticon.com`, `splitshire.com`.
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
