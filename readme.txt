=== WP IMAGE REFRESH ===
Contributors: girish.tiwari
Tags: image refresh, random image reload, image reload
Donate link: http://cueblocks.com/
Requires at least: 3.9.2
Tested up to: 4.2.2
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Image reload Plugin

== Description ==
This plugin is able to refresh images every time a page loads. Images are admin manageable where you can add multiple images and can show them in frontend by using short codes. This can be helpful when you want to refresh any image such as the header image on every time the page loads.

A few notes about the sections above:

*   This plugin is built in WordPress 3.9.2.
*   On frontend only the image tag will be visible which can be customized using your own styles.

== Installation ==
This section describes how to install the plugin and get it working.

Example.

1. Extract `wp_image_refresh.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the \'Plugins\' menu in WordPress
3. Place <?php echo do_shortcode( '[wp-image-refresh]' ); ?> in your templates or use [wp-image-refresh] in your pages or posts

== Frequently Asked Questions ==

= How to display image on template file? =

Use do_shortcode['wp-image-refresh'].


== Screenshots ==
1. This screen shot shows listing of slides in admin panel
2. This is the screen shot of adding slides

== Changelog ==
= 1.1 =
* Removed deprecated php functions.

= 1.0  =
* Initial release

== Upgrade Notice ==
= 1.1 =
Removed deprecated php functions.

