#!/usr/bin/env bash
#
# Artifact Theme Reviewer — Theme Unit Test Data Automator
# Official WordPress.org Theme Unit Test Data Setup & Verification
# Reference: https://make.wordpress.org/themes/handbook/review/required/theme-unit-test/
#

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SKILL_DIR="$(dirname "${SCRIPT_DIR}")"
DATA_DIR="${SKILL_DIR}/data"
XML_URL="https://raw.githubusercontent.com/WPTT/theme-unit-test/master/themeunittestdata.wordpress.xml"
XML_FILE="${DATA_DIR}/themeunittestdata.wordpress.xml"

COMMAND="${1:-help}"

# Run from the WordPress root. Set WP_BASE_URL when the site's wp-config.php
# needs a URL to build its own (the e2e suite reads the same variable).
wp() {
    command wp ${WP_BASE_URL:+--url="${WP_BASE_URL}"} "$@"
}

mkdir -p "${DATA_DIR}"

ensure_xml() {
    if [[ ! -f "${XML_FILE}" ]]; then
        echo "==> Downloading official Theme Unit Test data from WPTT repo..."
        curl -fsSL "${XML_URL}" -o "${XML_FILE}"
        echo "    Saved to ${XML_FILE}"
    else
        echo "==> Using cached Theme Unit Test data at ${XML_FILE}"
    fi
}

cmd_import() {
    ensure_xml

    echo "==> Ensuring wordpress-importer plugin is installed & active..."
    if ! wp plugin is-installed wordpress-importer 2>/dev/null; then
        wp plugin install wordpress-importer --activate
    elif ! wp plugin is-active wordpress-importer 2>/dev/null; then
        wp plugin activate wordpress-importer
    fi

    echo "==> Importing Theme Unit Test data (posts, pages, media, users)..."
    wp import "${XML_FILE}" --authors=create

    cmd_configure_settings

    echo ""
    echo "=========================================================="
    echo "  Theme Unit Test Data Imported Successfully!             "
    echo "=========================================================="
    echo "Verification targets to check:"
    echo "  - Front Page / Blog Index (posts_per_page = 5, pagination active)"
    echo "  - Sticky post formatting"
    echo "  - Long title: Supercalifragilisticexpialidocious!"
    echo "  - Password protected post ('Protected Test With Secret Password')"
    echo "  - Post without body text & post without title"
    echo "  - Threaded comments (depth 3) & paginated comments (5/page)"
    echo "  - Categories & Tags overflow handling"
    echo "  - Search results & 404 page"
}

cmd_configure_settings() {
    echo "==> Applying official WordPress.org Theme Unit Test settings..."
    
    # 1. Reading: 5 posts per page to trigger pagination
    wp option update posts_per_page 5
    
    # 2. Discussion: Threaded comments 3 levels deep, 5 comments per page
    wp option update thread_comments 1
    wp option update thread_comments_depth 3
    wp option update page_comments 1
    wp option update comments_per_page 5
    
    # 3. Permalinks: Month and name
    wp rewrite structure '/%year%/%monthnum%/%postname%/'
    wp rewrite flush --hard

    echo "    - posts_per_page: 5"
    echo "    - thread_comments: 1 (depth: 3)"
    echo "    - page_comments: 1 (5 per page)"
    echo "    - permalinks: /%year%/%monthnum%/%postname%/"
}

cmd_verify() {
    echo "==> Auditing Theme Unit Test requirements against local site..."
    
    SITE_URL="$(wp option get siteurl)"
    echo "    Site URL: ${SITE_URL}"
    
    # 1. Verify blog index pagination
    echo -n "  [1/6] Blog pagination (page/2): "
    HTTP_CODE=$(curl -sk -o /dev/null -w "%{http_code}" "${SITE_URL}/page/2/" || true)
    if [[ "${HTTP_CODE}" == "200" || "${HTTP_CODE}" == "301" ]]; then
        echo "PASS (HTTP ${HTTP_CODE})"
    else
        echo "NOTICE (HTTP ${HTTP_CODE})"
    fi

    # 2. Verify search page
    echo -n "  [2/6] Search query handling: "
    SEARCH_CODE=$(curl -sk -o /dev/null -w "%{http_code}" "${SITE_URL}/?s=test" || true)
    if [[ "${SEARCH_CODE}" == "200" ]]; then
        echo "PASS (HTTP ${SEARCH_CODE})"
    else
        echo "FAIL (HTTP ${SEARCH_CODE})"
    fi

    # 3. Verify 404 fallback
    echo -n "  [3/6] 404 error page: "
    NOT_FOUND_CODE=$(curl -sk -o /dev/null -w "%{http_code}" "${SITE_URL}/not-found-unit-test-check/" || true)
    if [[ "${NOT_FOUND_CODE}" == "404" ]]; then
        echo "PASS (HTTP 404 as expected)"
    else
        echo "NOTICE (HTTP ${NOT_FOUND_CODE})"
    fi

    # 4. Check for sticky post
    echo -n "  [4/6] Sticky posts in database: "
    STICKY_COUNT=$(wp post list --post__in="$(wp option get sticky_posts | tr ',' ' ')" --format=count 2>/dev/null || echo "0")
    echo "${STICKY_COUNT} sticky post(s) present"

    # 5. Check comments configuration
    echo -n "  [5/6] Threaded comment settings: "
    DEPTH=$(wp option get thread_comments_depth)
    echo "Depth ${DEPTH} (Handbook requires >= 3)"

    # 6. Check posts per page
    echo -n "  [6/6] Posts per page setting: "
    PPP=$(wp option get posts_per_page)
    echo "${PPP} (Handbook requires 5)"

    echo "==> Audit check complete."
}

case "${COMMAND}" in
    import)
        cmd_import
        ;;
    settings)
        cmd_configure_settings
        ;;
    verify)
        cmd_verify
        ;;
    download)
        ensure_xml
        ;;
    help|-h|--help)
        echo "Usage: $0 {import|settings|verify|download}"
        echo ""
        echo "Commands:"
        echo "  import    Download test XML, install importer, import stub data & configure settings"
        echo "  settings  Apply official handbook settings (posts_per_page=5, threaded comments depth 3)"
        echo "  verify    Audit test endpoints and settings on the active site"
        echo "  download  Download and cache themeunittestdata.wordpress.xml"
        exit 0
        ;;
    *)
        echo "Usage: $0 {import|settings|verify|download}"
        echo ""
        echo "Commands:"
        echo "  import    Download test XML, install importer, import stub data & configure settings"
        echo "  settings  Apply official handbook settings (posts_per_page=5, threaded comments depth 3)"
        echo "  verify    Audit test endpoints and settings on the active site"
        echo "  download  Download and cache themeunittestdata.wordpress.xml"
        exit 1
        ;;
esac
