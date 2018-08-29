# UCF FAQ CPT Plugin #


## Description ##

Provides a custom post type for describing FAQs and supporting shortcodes. This theme supports the [UCF Athena Framework](https://github.com/UCF/Athena-Framework).

The following templates can be overwritten in the theme.
* single-faq.php
* archive-faq.php
* taxonomy-topic.php


## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress]

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/UCF-FAQ-CPT/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.

### Required Plugins
These plugins *must* be activated for the theme to function properly.
* Advanced Custom Fields PRO

### Supported Plugins
The plugins listed below are extended upon in this theme--this may include custom layouts for feeds, style modifications, etc.  These plugins are not technically required on sites running this theme, and shouldn't be activated on sites that don't require their features.  A plugin does not have to be listed here to be compatible with this theme.
* UCF Spotlight

## Configuration

* Import field groups (`dev/acf-fields.json`) using the ACF importer under Custom Fields > Tools.

## Changelog ##

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Installation Requirements ##

None


## Development & Contributing ##

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.
