=== UCF FAQ CPT Plugin ===
Contributors: ucfwebcom
Tags: ucf, faq, ucf-plugin, custom post type
Requires at least: 4.7.3
Tested up to: 5.3
Stable tag: 1.1.2
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html


== Description ==

Provides a custom post type for describing FAQs and creates supporting shortcodes. This plugin supports the [UCF Athena Framework](https://github.com/UCF/Athena-Framework) (Required by the Topic list's "card" layout, and optionally for the FAQ list "classic" layout).

The following templates can be overwritten in the plugin.
* single-faq.php
* archive-faq.php
* taxonomy-topic.php


== Installation ==

= Manual Installation =
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress]

= WP CLI Installation =
1. `$ wp plugin install --activate https://github.com/UCF/UCF-FAQ-CPT/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.

### Required Plugins
These plugins *must* be activated for the plugin to function properly.
* [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/)

### Supported Plugins
The plugins listed below are extended upon in this plugin--this may include custom layouts for feeds, style modifications, etc.  These plugins are not technically required on sites running this plugin, and shouldn't be activated on sites that don't require their features.  A plugin does not have to be listed here to be compatible with this plugin.
* [UCF Spotlight](https://github.com/UCF/UCF-Spotlights-Plugin)

## Configuration

* Import field groups (`dev/acf-fields.json`) using the ACF importer under Custom Fields > Tools.

== Changelog ==

= 1.1.2 =
Enhancements:
* Moved collapse classes/attrs up to the FAQ's parent `<a>` tag to prevent issues with misclicks opening the single FAQ post instead of toggling the accordion
* Added `aria-expanded` attr to FAQ collapse links for improved accessibility

= 1.1.1 =
* Added ability to customize (and remove) View All FAQs call-to-action button on FAQ lists (`footer_cta_text` and `footer_cta_url` shortcode params).  Either of these new shortcode params can be set to a blank value (e.g. `footer_cta_text=""` to disable the button entirely.)

= 1.1.0 =
* Upgraded packages to latest versions
* Moved topic and question fields to code
* Fixed pagination on admin FAQ list views
* Added line-height style to `.ucf-faq-question`

= 1.0.1 =
* Fixed a debug log message

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Installation Requirements ==

None


== Development & Contributing ==

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.
