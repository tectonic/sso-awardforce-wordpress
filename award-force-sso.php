<?php
/*
 * Plugin Name: Award Force SSO
 * Plugin URI: https://www.awardforce.com/
 * Description: A WordPress plugin supporting single sign-on via Award Force
 * Author: Creative Force
 * Version: 1.5
 * Author URI: https://www.creativeforce.team/
 * License: GPL2+
 * Text Domain: award-force-sso
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
        $awardForce = new AwardForceSSO(new AwardForceAPIV2);
        $awardForce->sso();
    }
});
