<?php
/**
 * Delete options upon uninstall to prevent issues with other plugins and leaving trash behind.
 */

// Exit, if uninstall.php was not called from WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die();
}

delete_option( 'MatomoAnalyticsPP' );
delete_site_option( 'MatomoAnalyticsPP' );
