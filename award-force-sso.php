<?php
/*
Plugin Name: Award Force SSO
Version: 1.0
Author: Tectonic Digital
Description: A WordPress plugin supporting single sign-on via Award Force
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require 'vendor/autoload.php';

/*----------------------------------------------------------------------------*
 * Admin functionality
 *----------------------------------------------------------------------------*/
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
    $admin = new AwardForceSSO_Admin;

    add_action( 'admin_init', [ $admin, 'register_settings' ] );
    add_action( 'admin_menu', [ $admin, 'register_menu' ] );
}

/*----------------------------------------------------------------------------*
 * Public-Facing functionality
 *----------------------------------------------------------------------------*/
add_action('init', function () {
    if ( strstr( $_SERVER['REQUEST_URI'], '/awardforce/sso' ) ) {
        $awardForce = new AwardForceSSO(new AwardForceAPI);
        $awardForce->sso();
    }
});