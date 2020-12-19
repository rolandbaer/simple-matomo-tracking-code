<?php
/**
 * Plugin Name: Simple Matomo Tracking Code
 * Plugin URI: http://www.rolandbaer.ch/software/wordpress/plugin-matomo-tracking/
 * Description: This plugin makes it simple to add Matomo Web Analytics code to your WebSite.
 * Version: 0.1.0
 * Author: Roland Bär
 * Author URI: http://www.rolandbaer.ch/
 * Text Domain: simple-matomo-tracking-code
 * License: GPLv3
 * 
 * Based on Jules Stuifbergen's Piwik Analytics plugin
 */

/*
 * Admin User Interface
 */

if ( ! class_exists( 'SMTC_Admin' ) ) {

	class SMTC_Admin {

		static function add_config_page() {
			global $wpdb;
			if ( function_exists('add_options_page') ) {
				add_options_page('Simple Matomo Tracking Code Configuration', 'Simple Matomo Tracking Code', 'manage_options', basename(__FILE__), array('SMTC_Admin','config_page'));
			}
		}

		function restore_defaults() {
			$options['siteid'] = 1;
			$options['matomo_host'] = '';
			$options['matomo_baseurl'] = '/matomo/';
			$options['admintracking'] = false;
			$options['dltracking'] = true;
			update_option('MatomoAnalyticsPP',$options);
		}

		function init() {
			$options  = get_option('MatomoAnalyticsPP');
			if (empty($options)) {
				$this->restore_defaults();
			}
		}

		static function config_page() {
			if (isset($_GET['reset']) && $_GET['reset'] == "true") {
				restore_defaults();
			}

			if ( isset($_POST['submit']) ) {
				if (!current_user_can('manage_options')) die(__('You cannot edit the Simple Matomo Tracking Code options.'));
				check_admin_referer('analyticspp-config');
				$options['siteid'] = $_POST['siteid'];

				if (isset($_POST['matomo_baseurl']))
					$options['matomo_baseurl'] = strtolower($_POST['matomo_baseurl']);

				if (isset($_POST['matomo_host']))
					$options['matomo_host'] = strtolower($_POST['matomo_host']);

				if (isset($_POST['dltracking'])) {
					$options['dltracking'] = true;
				} else {
					$options['dltracking'] = false;
				}

				if (isset($_POST['admintracking'])) {
					$options['admintracking'] = true;
				} else {
					$options['admintracking'] = false;
				}

				update_option('MatomoAnalyticsPP', $options);
			}

			$options  = get_option('MatomoAnalyticsPP');
			?>
			<div class="wrap">
				<script type="text/javascript">
					function toggle_help(ele, ele2) {
						var expl = document.getElementById(ele2);
						if (expl.style.display == "block") {
							expl.style.display = "none";
							ele.innerHTML = "What's this?";
						} else {
							expl.style.display = "block";
							ele.innerHTML = "Hide explanation";
						}
					}
				</script>
				<h2>Simple Matomo Tracking Code Configuration</h2>
				<form action="" method="post" id="analytics-conf">
					<table class="form-table" style="width:100%;">
					<?php
					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('analyticspp-config');
					?>
					<p>Matomo, formerly known as Piwik, is a downloadable web analytics software platform
						free of charge under the GPL license.<br />
						If you don't have Matomo installed, you can get it at
						<a href="https://matomo.org/">matomo.org</a>.</p>

					<tr>
						<th scope="row" valign="top">
							<label for="siteid">Matomo site id</label>
						</th>
						<td>
							<input id="siteid" name="siteid" class="small-text" type="number" size="3" maxlength="4" value="<?php echo $options['siteid']; ?>" /><br/>
							<div id="expl">
								<p>In the Matomo interface, when you "Add Website"
									you are shown a piece of JavaScript that
									you are told to insert into the page, in that script is a 
									unique string that identifies the website you 
									just defined, that is your site ID (usually "1").
								<p>Once you have entered your site id in
									the box above your pages will be trackable by
									Matomo Web Analytics.</p>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="dltracking">Track downloads</label><br/>
							<small>(default is YES)</small>
						</th>
						<td>
							<input type="checkbox" id="dltracking" name="dltracking" <?php if ($options['dltracking']) echo ' checked="unchecked" '; ?>/> 
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="matomo_host">Hostname of the matomo server (optional)</label>
						</th>
						<td>
							<input id="matomo_host" name="matomo_host" type="text" size="40" maxlength="99" value="<?php echo $options['matomo_host']; ?>" /><br/>
							<div id="expl3">
								<p>Example: www.yourdomain.com -- Leave blank (default) if this is the same as your website.
								Do NOT include the http(s):// bit.</p>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="matomo_baseurl">Base URL path of matomo installation</label>
						</th>
						<td>
							<input id="matomo_baseurl" name="matomo_baseurl" type="text" size="40" maxlength="99" value="<?php echo $options['matomo_baseurl']; ?>" /><br/>
							<div id="expl2" style="display:none;">
								<p>The URL path to the matomo installation. E.g. /matomo/ or /stats/. Don't forget the trailing slash!</p>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="admintracking">Track the admin user too</label><br/>
							<small>(default is not to)</small>
						</th>
						<td>
							<input type="checkbox" id="admintracking" name="admintracking" <?php if ($options['admintracking']) echo ' checked="checked" '; ?>/> 
						</td>
					</tr>
					</table>
					<p style="border:0;" class="submit"><input type="submit" name="submit" value="Update Settings &raquo;" /></p>
				</form>
				<p>All options set? Then <a href="http://<?php if ($options['matomo_host']) { echo $options['matomo_host']; }else{ echo $_SERVER['HTTP_HOST'];}; echo $options['matomo_baseurl']; ?>" title="Matomo admin url" target="_blank">check out your stats!</a>
			</div>
			<?php
			if (isset($options['siteid'])) {
				if ($options['siteid'] == "") {
					add_action('admin_footer', array('SMTC_Admin','warning'));
				} else {
					if (isset($_POST['submit'])) {
						if ($_POST['siteid'] != $options['siteid'] ) {
							add_action('admin_footer', array('SMTC_Admin','success'));
						}
					}
				}
			} else {
				add_action('admin_footer', array('SMTC_Admin','warning'));
			}

		} // end config_page()

		function success() {
			echo "
			<div id='analytics-warning' class='updated fade-ff0000'><p><strong>Congratulations! You have just activated Matomo Web Analytics.</p></div>
			<style type='text/css'>
			#adminmenu { margin-bottom: 7em; }
			#analytics-warning { position: absolute; top: 7em; }
			</style>";
		}

		function warning() {
			echo "
			<div id='analytics-warning' class='updated fade-ff0000'><p><strong>Matomo Web Analytics is not active.</strong> You must <a href='plugins.php?page=piwikanalytics.php'>enter your Site ID</a> for it to work.</p></div>";
		}
	}
}


/**
 * Code that actually inserts stuff into pages.
 */
if ( ! class_exists( 'SMTC_Filter' ) ) {
	class SMTC_Filter {

		/*
		 * Insert the tracking code into the page
		 */
		static function spool_analytics() {
			?><!-- Matomo plugin active --><?php
			
			$options  = get_option('MatomoAnalyticsPP');
			
			if ($options["siteid"] != "" && (!current_user_can('edit_users') || $options["admintracking"]) && !is_preview() ) { ?>
				<!-- Matomo code inserted by Simple Matomo Tracking Code plugin -->
				<script type="text/javascript">
				<?php if ( $options['matomo_host'] ) { ?>
					var pkBaseURL = document.location.protocol + "//" + "<?php echo $options['matomo_host']; ?>" + "<?php echo $options['matomo_baseurl']; ?>";
				<?php } else { ?>
					var pkBaseURL = document.location.protocol + "//" + document.location.host + "<?php echo $options['matomo_baseurl'] ?>";
				<?php
			};
			?>
				document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
				</script><script type="text/javascript">
				try {
				var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?php echo $options['siteid']; ?>);
				piwikTracker.setDocumentTitle(document.title);
				piwikTracker.trackPageView();
			<?php
			if ( $options["dltracking"]) { ?>
				piwikTracker.enableLinkTracking();
			<?php } ?>
				} catch( err ) {}
				</script>
				<!-- /Matomo -->
	<?php
			}
		}
	}
}

$options  = get_option('MatomoAnalyticsPP',"");


// adds the menu item to the admin interface
add_action('admin_menu', array('SMTC_Admin','add_config_page'));

// adds the footer so the javascript is loaded
add_action('wp_footer', array('SMTC_Filter','spool_analytics'));	

/**
 * Register the "book" custom post type
 */
function pluginprefix_setup_post_type() {
    register_post_type( 'book', ['public' => true ] ); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );
 
 
/**
 * Activate the plugin.
 */
function simple_matomo_tracking_code_activate() { 
	$admin = new SMTC_Admin();
	$admin->init();
}

register_activation_hook( __FILE__, 'simple_matomo_tracking_code_activate' );
?>
