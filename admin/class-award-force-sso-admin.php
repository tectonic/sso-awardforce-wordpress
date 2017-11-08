<?php

class AwardForceSSO_Admin {

    public function register_menu()
    {
        add_menu_page( 'Award Force', 'Award Force', 'administrator','award-force-sso-settings', [ $this, 'display_settings_page' ] );
    }

    public function register_settings()
    {
        register_setting( 'award-force-sso-settings-group', 'award-force-sso-installation-domain' );
        register_setting( 'award-force-sso-settings-group', 'award-force-sso-api-key' );
    }

    public function display_settings_page()
    {
        require_once 'views/award-force-sso-settings.php';
    }
}