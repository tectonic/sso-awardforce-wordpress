<div class="wrap">
    <h2>Award Force</h2>
    <form method="POST" action="options.php">
        <?php settings_fields( 'award-force-sso-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">API URL</th>
                <td><input type="text" name="award-force-sso-api-url" value="<?php echo get_option( 'award-force-sso-api-url' ); ?>" size="100" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">API Key</th>
                <td><input type="text" name="award-force-sso-api-key" value="<?php echo get_option( 'award-force-sso-api-key' ); ?>" size="100" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Award Force installation URL</th>
                <td><input type="text" name="award-force-sso-installation-url" value="<?php echo get_option( 'award-force-sso-installation-url' ); ?>" size="100" /></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
        </p>
    </form>
</div>