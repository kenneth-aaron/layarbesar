<?php

/*----------------------------------------------------------------------------------------------------------
    Uninstall Idmuvi Core plugin and delete all options from database
-----------------------------------------------------------------------------------------------------------*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$idmuv_other = get_option( 'idmuv_other' );

if ( isset ( $idmuv_other['other_remove_data_when_uninstall'] ) && $idmuv_other['other_remove_data_when_uninstall'] != '' ) {
	// option, section, default
	$option = $idmuv_other['other_remove_data_when_uninstall'];
} else {
	$option = 'off';
}

if ( $option == 'on' ) {
	// Delete option from database
	delete_option( 'idmuv_relpost' );
	delete_option( 'idmuv_breadcrumbs' );
	delete_option( 'idmuv_ads' );
	delete_option( 'idmuv_social' );
	delete_option( 'idmuv_tmdb' );
	delete_option( 'idmuv_ajax' );
	delete_option( 'idmuv_player' );
	delete_option( 'idmuv_other' );
}