=== Artifact ===
Contributors: aminurislamarnob
Requires at least: 6.9
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A black WordPress block theme for company websites.

== Description ==

Artifact is a full site editing (block) theme with a black default look: dark surfaces, light type, and an orange accent. It ships a Homepage dark composition for the front page, plus generic templates for pages, posts, archives, search, and 404.

The theme uses self-hosted Poppins (WOFF2), tokens in theme.json, and PHP block patterns. It does not load remote fonts, images, or scripts.

== Installation ==

1. In your admin panel, go to Appearance → Themes and click the Add New button.
2. Click Upload Theme and choose the artifact zip.
3. Click Install Now, then Activate.
4. Open Appearance → Editor to customise templates, parts, and styles.

The homepage's blog section shows a View All button once the site has a posts page. To add one, go to Settings → Reading, set Your homepage displays to A static page, and choose a Posts page.

== Recommended plugins ==

Artifact works fully without plugins. Its Contact page pattern is designed for Contact Form 7 (https://wordpress.org/plugins/contact-form-7/) and its footer newsletter for Brevo (https://wordpress.org/plugins/mailin/). The theme recommends both in a dismissable admin notice and under Appearance → Install Plugins. Installing them is optional.

To take messages on the Contact page:

1. Install and activate Contact Form 7, then create a form under Contact → Contact Forms.
2. Edit your Contact page. In the message panel, keep the "Send us a message" heading, remove the paragraph under it and the "Send Inquiry" button, and add a Contact Form 7 block for your form in their place.

The theme styles Contact Form 7 forms everywhere, and lays them out in two columns inside the message panel. Fields holding a message box or the submit button span both columns.

Without a newsletter plugin, the footer's Subscribe Us column links to the site's RSS feed. To collect email sign-ups instead:

1. Install and activate Brevo, connect your Brevo account, and note the ID of your form under Brevo → Forms.
2. Open Appearance → Editor → Patterns → Footer. In the Subscribe Us column, remove the paragraph and the "Subscribe via RSS" button, and add a Shortcode block holding [sibwp_form id=1] (use your form's ID). In the form's HTML under Brevo → Forms, give the email field a label element (for example <label for="sib-email">Email Address*</label> with id="sib-email" on the input) so screen readers can name it.

The theme styles Brevo forms everywhere, and in the footer sets the email field beside a square arrow button.

== Changelog ==

= 1.0.0 =
* Initial release.

== Copyright ==

Artifact WordPress Theme, Copyright 2026 Aminur Islam Arnob
Artifact is distributed under the terms of the GNU GPL.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Bundled resources ==

= Fonts =

Poppins
Copyright 2020 The Poppins Project Authors (https://github.com/itfoundry/Poppins)
Source: https://fonts.google.com/specimen/Poppins
License: SIL Open Font License, Version 1.1 (https://openfontlicense.org)
License file: assets/fonts/OFL.txt
Files: assets/fonts/Poppins-Regular.woff2, Poppins-Medium.woff2, Poppins-SemiBold.woff2, Poppins-Bold.woff2

= Code =

TGM Plugin Activation
Copyright Thomas Griffin, Gary Jones, Juliette Reinders Folmer
Source: http://tgmpluginactivation.com/
License: GPL-2.0-or-later (https://www.gnu.org/licenses/gpl-2.0.html)
Files: inc/class-tgm-plugin-activation.php (version 2.6.1, text domain set to artifact)

= Images =

Material Symbols
Copyright Google LLC
Source: https://fonts.google.com/icons
License: Apache License 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
Files: icon-arrow-outward.svg (arrow_outward, also inlined in theme.json as the Contact Form 7 and Brevo submit arrow), icon-arrow-right.svg (arrow_forward), icon-service-theme.svg (palette), icon-service-plugin.svg (extension), icon-service-commerce.svg (shopping_cart), icon-service-wordpress.svg (web), icon-service-api.svg (api), icon-service-security.svg (shield_lock), icon-service-single-store.svg (storefront), icon-service-multi-vendor.svg (store), icon-service-speed.svg (speed), icon-service-mobile-app.svg (phone_iphone), icon-service-automation.svg (account_tree), icon-service-support.svg (support_agent), icon-feature-care.svg (volunteer_activism), icon-feature-team.svg (groups), icon-feature-support.svg (support_agent), icon-mail.svg (mail), icon-phone.svg (call), icon-location.svg (location_on), icon-schedule.svg (schedule), icon-value-expertise.svg (route), icon-value-communication.svg (chat), icon-value-reliability.svg (thumb_up), icon-value-growth.svg (rocket_launch), icon-fact-solutions.svg (lightbulb), icon-fact-experience.svg (calendar_month), icon-fact-projects.svg (work), icon-fact-customers.svg (sentiment_satisfied), icon-fact-countries.svg (public), stars-rating.svg (star, filled)

StockSnap
License: CC0 1.0 Universal, public domain dedication (https://stocksnap.io/license)
Files: service-laptop-code.jpg (https://stocksnap.io/photo/laptop-computer-W0RUS6FWBJ), service-laptop-desk.jpg (https://stocksnap.io/photo/laptop-desk-WTSQO9T3DK), service-monitor-desk.jpg (https://stocksnap.io/photo/computer-desk-GVYM0DWG9D), company-meeting.jpg (https://stocksnap.io/photo/business-people-TERDBIUUK7), company-celebration.jpg (https://stocksnap.io/photo/business-team-E44XSGB9A7), portfolio-code-screen.jpg (https://stocksnap.io/photo/computer-keyboard-A28WZDTYEY), portfolio-laptop-typing.jpg (https://stocksnap.io/photo/computer-laptop-RP7FCYXZMO), portfolio-team-desk.jpg (https://stocksnap.io/photo/conferenceroom-meeting-GVUWVKUHZE), portfolio-vr-headset.jpg (https://stocksnap.io/photo/virtual-reality-PFHFKXTMYD), portfolio-laptop-wood.jpg (https://stocksnap.io/photo/business-woman-7U4SPRJEIE), portfolio-monitors.jpg (https://stocksnap.io/photo/woman-developer-64EKVZ4V2B), portfolio-home-office.jpg (https://stocksnap.io/photo/office-work-N0ZRKV9CI6), portfolio-laptop-plant.jpg (https://stocksnap.io/photo/laptop-desk-JCXQS3IVWD), hero-illustration-main.webp (https://stocksnap.io/photo/woman-working-FTBGHTW6EJ, cropped and masked to the hero shape), about-team.jpg (https://stocksnap.io/photo/business-woman-XP4FYCFL1N), work-desk.jpg (https://stocksnap.io/photo/woman-developer-HMPNPRBUJ7), team-a.jpg (https://stocksnap.io/photo/male-portrait-NLX0RAPBGB, greyscale), team-b.jpg (https://stocksnap.io/photo/woman-business-3WCJNINSRD, greyscale), team-c.jpg (https://stocksnap.io/photo/male-professional-LLBULYYEGR, greyscale), team-d.jpg (https://stocksnap.io/photo/woman-model-CRHFNXOZMG, greyscale), team-e.jpg (https://stocksnap.io/photo/businessman-thinking-TGG4JHNHB8, greyscale), team-f.jpg (https://stocksnap.io/photo/woman-smartphone-MLEPUKHYUU, greyscale), team-g.jpg (https://stocksnap.io/photo/male-musician-GI7Y9QLX0K, greyscale), team-h.jpg (https://stocksnap.io/photo/female-portrait-STXDKVUDL5, greyscale), story-wade-a.jpg (https://stocksnap.io/photo/smiling-man-YXWIOQNMOT), story-wade-b.jpg (https://stocksnap.io/photo/man-thinking-HX73V27KEX), story-wade-c.jpg (https://stocksnap.io/photo/businessman-call-0MQJHREWOL)

Homepage dark artwork exported from Figma file rhXpPSv3HxiGpTiN733snB, node 9100:115184 (vector shapes and a background texture, no photos). Original artwork, GPL-2.0-or-later as part of this theme.
Files: hero-badge-projects.svg, hero-card-client.svg, hero-pill-work.svg, hero-sparkle.svg, hero-vector-pink.svg, cta-bg.png
