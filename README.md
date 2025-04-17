# Find Pre Init Translations

**Version:** 1.0.0  
**Author:** jaimelias  
**Plugin URI:** https://github.com/jaimelias/find-pre-init-translations  
**License:** GPL‑2.0+

---

## Description

Find Pre Init Translations logs all `gettext()` calls triggered **before** the `init` hook for non‑default domains. It helps WordPress developers identify translation-order issues and resolve the common error after Wordpress 6.7:

> **Function _load_textdomain_just_in_time was called incorrectly.**

When early translations run out of order, this plugin captures the hook, text, domain, and file location, then outputs it to the debug log (or directly on screen if `WP_DEBUG_DISPLAY` is enabled).

## Features

- Hooks into `gettext` with priority `0` to catch the earliest translations.
- Skips core (`default`) domain translations.
- Honors `WP_DEBUG` and `WP_DEBUG_DISPLAY` settings.
- Outputs a backtrace location so you can pinpoint the culprit plugin or theme.

## Installation

1. Download or clone this repository into your WordPress `wp-content/plugins/` folder:
   ```bash
   git clone https://github.com/jaimelias/find-pre-init-translations.git
   ```
2. Ensure your `wp-config.php` has debug turned on:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   // Optional: show logs in browser
   define('WP_DEBUG_DISPLAY', true);
   ```
3. In the WordPress admin, go to **Plugins → Installed Plugins** and activate **Find Pre Init Translations**.

## Usage

- Browse your site or trigger the functionality you suspect runs too early.
- Check `wp-content/debug.log` (or your PHP error log) for entries like:
  ```text
  <br>Pre Init Translations - hook="plugins_loaded"; text="My String"; domain="my-plugin"; location="/path/to/file.php on line 123";<br>
  ```
- The log will show you:
  - **hook** where the translation was invoked
  - **text** being translated
  - **domain** (plugin/theme text domain)
  - **location** of the calling file and line number

Use this information to adjust your plugin or theme so that `load_textdomain()` and other translation functions run **during or after** `init`.

## Changelog

### 1.0.0
- Initial release.

## Contributing

Contributions are welcome! Please fork the repo and submit a pull request with your improvements.

## License

This plugin is licensed under the [GPL‑2.0+](https://www.gnu.org/licenses/gpl-2.0.html) license.

