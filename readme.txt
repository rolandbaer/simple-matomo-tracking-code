=== Simple Matomo Tracking Code ===
Contributors: rbaer
Tags: matomo, piwik, analytics, stats, statistics
Requires at least: 5.0
Tested up to: 5.6
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Stable tag: 0.1.0

This unofficial plugin adds the Matomo Web Analytics javascript code into the footer of
your website. It has several useful options.

== Description ==

This is a unofficial, basic WordPress plugin for the Matomo web analytics software platform.
It adds the Matomo javascript code into every page of your website, so
you don't have to code PHP to add it to your templates.

It is based quite heavily on the (no more supported) Piwik Analytics WordPress plugin which 
itself is based on the (no more available) Google Analytics wordpress plugin by Joost de Valk.

The following options are supported:

* matomo hostname
* matomo path
* site ID
* option to control download tracking
* option to exclude the admin user (probably you)

Please note, this plugin requires a running Matomo installation somewhere under
your control. It does not include Matomo itself.

See also [The Matomo Website](https://matomo.org/).


== Installation ==

1. Install and activate the plugin as you normally would. (You can find more details and
   instructions [here](https://wordpress.org/support/article/managing-plugins/).)
2. Visit the "Simple Matomo Tracking Code" page in the "Settings" section and adjust the parameters.
   Don’t forget to click "Save Changes" when you're done.


== Changelog ==

= 0.1.0 =
* created plugin based on piwik-analytics


== Frequently Asked Questions ==

Q: The Matomo Web Analytics javascript code does not show up.
A1: Make sure your theme has a call to wp_footer() in the footer.php file
A2: Make sure you're not logged in as admin.

