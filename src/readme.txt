=== Simple Matomo Tracking Code ===
Contributors: rbaer
Tags: matomo, piwik, analytics, stats, statistics
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Stable tag: 1.1.0

This unofficial plugin adds the Matomo Web Analytics javascript code into the footer of your website. It has several useful options.

== Description ==

This is a unofficial, basic WordPress plugin for the Matomo web analytics software platform.
It adds the Matomo javascript code into every page of your website, so you don't have to code PHP to add it to your templates.

It is based quite heavily on the (no more supported) Piwik Analytics WordPress plugin which itself is based on the (no more available) Google Analytics wordpress plugin by Joost de Valk.

The following options are supported:

* matomo hostname
* matomo path
* site ID
* option to control download tracking
* option to exclude the admin user (probably you)

Please note, this plugin requires a self-contained Matomo installation somewhere under your control. It does not include Matomo itself.

See also [The Matomo Website](https://matomo.org/).


== Installation ==

1. Install and activate the plugin as you normally would.
   (You can find more details and instructions [here](https://wordpress.org/support/article/managing-plugins/).)
2. Visit the "Simple Matomo Tracking Code" page in the "Settings" section and adjust the parameters.
   Don’t forget to click "Update Settings" when you're done.


== Changelog ==

= 1.1.0 =
* uninstall updated for multisite compatibility

= 1.0.3 =
* Bugfix for reset, fixes from static code analysis, requires now PHP 7.1 or higher

= 1.0.2 =
* changed texts

= 1.0.1 =
* code cleanup: moved duplicated code in function

= 1.0.0 =
* prepared for translations

= 0.5.2 =
* fix for wrong appended path (to many slashes)

= 0.5.1 =
* input validation

= 0.5.0 =
* new javascript code from matomo
* remove configuration during uninstall
* fixed warnings

= 0.1.0 =
* created plugin based on piwik-analytics


== Frequently Asked Questions ==

= The Matomo Web Analytics javascript code does not show up. =

1. Make sure your theme has a call to wp_footer() in the footer.php file
2. Make sure you're not logged in as admin.

= How can I report security bugs? =

You can report security bugs through the Patchstack Vulnerability Disclosure
Program. The Patchstack team help validate, triage and handle any security 
vulnerabilities. [Report a security vulnerability.](https://patchstack.com/database/vdp/simple-matomo-tracking-code)

Or you send them directly to [info@rolandbaer.ch](mailto:info@rolandbaer.ch).
