=== WP Think Framework ===
Contributors: allrain
Tags: wordpress-framework, theme-framework, options-framework

Requires at least: 4.0
Tested up to: 4.7
Stable tag: 1.0.0
License: GNU General Public License v3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html

== Description ==

WordPress Think Framework gives you the ability to quickly and easily create incredible websites with WordPress.  It Is an extensible framework for WordPress themes development. Based on the WordPress APIs.

== Installation ==

1. Download framework from Github repo - https://github.com/alex-storojenko/wp-think-framework
2. Extract and copy folder with files of framework to theme dir({wp-installation-folder}/wp-content/themes/{your-theme-directory})
3. OR You can copy folder with framework somewhere.
4. Include wp-think-framework.php to functions.php of your theme(require_once get_template_directory() . '/{wp-think-framework_root_dir}/wp-think-framework.php')
5. (exclude this until wp-think-framework1.12.* version) Create instance of framework - Think_Framework::get_instance() in functions.php of your current theme;
6. Create something amazing

== Changelog ==

= 1.0 =
* Initial release
* Added server requirements and short description how to install

= 1.0.1 =
* Fix critical bug Think_Metaboxes::create()
* Fix small bug with enqueue assets for Think_Metaboxes

= 1.11.9 =
* Global refactor according WordPress codestyle
* Refactor include assets
* Rework metabox registration
* Added sanitizer class
* Added possible register options with same id's for different pages
* Added examples of structures for registration metboxes and options
* Added possibility use inputs for different initiators
* Fix small bugs
* Fix critical error in Think_Customizer::create()
* Rework server requirements
* Composer init
* Add CSS to metabox inputs
* Fix uploader button with multiple image inputs
* Fix js for wp_editor on customizer
* Fix js for custom uploader caller
* Add fields walker trait
* Change readme
* Customizer preview script with auto value binding for registered customize sittings
* Rework customizer to singleton
* Add date type of control to customize
* Refactor CSS
* Fix bug preview image popup

= 1.12.0 =
* Change mechanism of framework installation

= 1.13.2 =
* Fix small bags
* And Change Think_Customizer caller Think_Customizer::customizer($structure) to Think_Customizer::instance($structure)

= 1.14.0 =
* Fix small bugs
* Change Think_Customizer caller Think_Customizer::customize($structure)
* Add possible multiple uses Think_Customizer::customize();

= 1.14.1 =
* Add comments to contract
* Fix small bugs in metabox factory
* Add ob in option page template

= 1.14.2 =
* Bugfix
* Correct license slug in composer.json

= 1.14.3 =

* Bugfix
* Codestyle changes