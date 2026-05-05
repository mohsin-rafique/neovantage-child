# NEOVANTAGE Child — Starter Child Theme

![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-6.7%2B-blue)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-purple)
![Tested up to](https://img.shields.io/badge/Tested%20up%20to-WP%206.9-brightgreen)
![Version](https://img.shields.io/badge/Version-1.0.0-orange)
![Parent: NEOVANTAGE](https://img.shields.io/badge/Parent-NEOVANTAGE-blueviolet)

A clean, minimal child theme for [NEOVANTAGE](https://wordpress.org/themes/neovantage/). Drop in your custom CSS, override parent template parts, and add bespoke functions — without ever editing the parent theme. Your changes survive every parent-theme update.

> Built by [PixelsPress](https://pixelspress.com) · Source on [GitHub](https://github.com/mohsin-rafique/neovantage-child)

---

## Why a child theme?

Editing the parent theme directly is a trap: the next parent update overwrites your changes. A child theme is the WordPress-recommended way to customise a theme safely.

**You should use this child theme if you want to:**

- Add or override CSS without losing it on theme update
- Override a parent template (e.g. `template-parts/content.php`) by copying it into the child
- Add small custom functions, action hooks, or filter callbacks
- Change colours, fonts, or layout details that the Customizer doesn't expose

**You probably do not need a child theme if you only want to:**

- Change the site logo, header image, or palette colours — use the parent theme's Customizer
- Tweak widgets, menus, or sidebar content — use Appearance → Widgets / Menus
- Add tracking scripts or a privacy banner — use the parent's "Custom Code" Customizer fields

---

## Features

- **Single-handle stylesheet enqueue** — depends on the parent's already-registered `neovantage` handle, so the parent stylesheet is never loaded twice. Cleaner network waterfall, no double-paint.
- **Translation ready** — wired to the `neovantage-child` text domain with a clean `.pot` template under `/languages/`.
- **PHP 8.4 compatible** — `declare(strict_types=1);`, typed return signatures, no deprecated syntax. Lints cleanly under `php -l` on PHP 8.4.
- **WordPress 6.9 ready** — header declares `Requires at least: 6.7` / `Tested up to: 6.9` / `Requires PHP: 8.0`.
- **Prefix-clean** — all child callbacks live under the `neovantage_child_` prefix so they cannot collide with parent functions.
- **Tiny footprint** — four files, zero dependencies, no build step, no JavaScript.

---

## Requirements

| Item         | Minimum                                                                                                             |
| ------------ | ------------------------------------------------------------------------------------------------------------------- |
| WordPress    | 6.7                                                                                                                 |
| PHP          | 8.0                                                                                                                 |
| Parent theme | [NEOVANTAGE](https://wordpress.org/themes/neovantage/) (must be installed and present — does not need to be active) |

---

## Installation

**From WordPress Admin:**

1. Make sure the **NEOVANTAGE** parent theme is installed (Appearance → Themes → Add New → search "NEOVANTAGE")
2. Download the latest [release zip](https://github.com/mohsin-rafique/neovantage-child/releases/latest)
3. Go to **Appearance → Themes → Add New → Upload Theme**
4. Upload `neovantage-child.zip` and click **Activate**

**Manual / development install:**

```bash
cd wp-content/themes/
git clone https://github.com/mohsin-rafique/neovantage-child.git
```

Then activate **NEOVANTAGE Child** from Appearance → Themes.

---

## How to customise

### Add custom CSS

Open `style.css` and write your rules below the header comment block:

```css
/* Make all H1s in posts use the brand red instead of the default theme colour */
.entry-content h1 {
    color: #d9272e;
}
```

That's it — no enqueue boilerplate needed; the child stylesheet is already loaded after the parent.

### Override a parent template

Copy the file you want to change from the parent theme into the **same path** inside the child theme:

```bash
# example: customise the post-format quote layout
cp wp-content/themes/neovantage/template-parts/content-quote.php \
   wp-content/themes/neovantage-child/template-parts/content-quote.php
```

WordPress will load the child copy instead of the parent's.

### Add a custom function

Append to `functions.php`. Each callback should be prefixed `neovantage_child_` so it cannot collide with anything in the parent.

```php
/**
 * Append the current year to the site footer credit line.
 */
function neovantage_child_footer_year_filter( string $credit ): string {
    return $credit . ' · ' . esc_html( gmdate( 'Y' ) );
}
add_filter( 'neovantage_footer_credit', 'neovantage_child_footer_year_filter' );
```

### Add translations

Translate the `neovantage-child` text domain by dropping a `.po` / `.mo` pair into `/languages/`:

```
languages/neovantage-child-fr_FR.mo
languages/neovantage-child-fr_FR.po
```

Use [Loco Translate](https://wordpress.org/plugins/loco-translate/) or [Poedit](https://poedit.net/) with the included `neovantage-child.pot` as a template. The child theme bootstraps its own text domain on `after_setup_theme`, separate from the parent's `neovantage` domain.

---

## File layout

```
neovantage-child/
├── functions.php                 # stylesheet enqueue + textdomain bootstrap
├── style.css                     # child theme stylesheet (with theme header)
├── screenshot.png                # 1200×900 theme screenshot
├── languages/
│   └── neovantage-child.pot      # translation template
└── README.md
```

---

## Coding standards

This child theme follows the parent project's coding standards:

- **PHP 8.4 baseline.** All new files declare `strict_types=1`. Functions use typed parameters and return types where they aid clarity. No deprecated PHP features.
- **WordPress 6.7+.** Uses standard WP enqueue, hook, and i18n APIs. No custom DB queries; no raw `$wpdb` calls.
- **Prefixes.** Every function is prefixed `neovantage_child_`. Class names (when introduced) will use `Neovantage_Child_`.
- **i18n.** All user-facing strings — when added — must be wrapped (`__()`, `esc_html__()`, `_n()`, `_x()`) with the `neovantage-child` text domain. **Never** mix the parent's `neovantage` domain into child files.
- **Escape on output, sanitize on input.** Output uses `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`. Input uses `sanitize_text_field()`, `absint()`, etc. Every write path verifies a nonce **and** a capability.

Run a quick lint before committing:

```bash
php -l functions.php
```

---

## Versioning

This project follows [Semantic Versioning 2.0.0](https://semver.org/spec/v2.0.0.html):

| Bump                | When                                                                                   | Example           |
| ------------------- | -------------------------------------------------------------------------------------- | ----------------- |
| **MAJOR** (`X.0.0`) | Breaking change to a public hook, function name, or template path that sites depend on | `1.x.x` → `2.0.0` |
| **MINOR** (`x.Y.0`) | New feature or template override added in a backwards-compatible way                   | `1.0.0` → `1.1.0` |
| **PATCH** (`x.x.Z`) | Bug fix, CSS tweak, translation update, or documentation-only change                   | `1.0.0` → `1.0.1` |

**Git tag convention.** Tags are the plain version, no `v` prefix:

```bash
git tag 1.0.1
git push origin 1.0.1
```

The version in `style.css` (`Version: 1.0.0`) is the source of truth — bump it in the same commit that introduces the change, before tagging.

**Releases** are cut on GitHub: [github.com/mohsin-rafique/neovantage-child/releases](https://github.com/mohsin-rafique/neovantage-child/releases). Each release attaches a `neovantage-child.zip` with the theme directory at its root.

---

## Changelog

### 1.0.0 — 06 May, 2026

- Initial release.
- Single-handle stylesheet enqueue depending on the parent's `neovantage` handle (no double-load of the parent stylesheet).
- `neovantage_child_` callback prefix throughout.
- `declare(strict_types=1);` and typed return signatures in `functions.php`.
- `style.css` header declares `Requires at least: 6.7`, `Tested up to: 6.9`, `Requires PHP: 8.0`; HTTPS Theme URI / Author URI.
- Clean `neovantage-child.pot` translation template.
- 1200×900 `screenshot.png` per current WP.org spec.

---

## Credits

| Resource                                                              | License | Author      |
| --------------------------------------------------------------------- | ------- | ----------- |
| [NEOVANTAGE](https://wordpress.org/themes/neovantage/) (parent theme) | GPL v2+ | PixelsPress |

---

## License

NEOVANTAGE Child project is licensed under the [GNU General Public License v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).
