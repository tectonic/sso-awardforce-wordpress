<div class="wrap">
    <h2>Award Force</h2>

    <?php settings_errors(); ?>

    <form method="POST" action="options.php">
        <?php settings_fields( 'award-force-sso-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Award Force URL</th>
                <td>
                    https://<input type="text" name="award-force-sso-installation-domain" value="<?php echo get_option( 'award-force-sso-installation-domain' ); ?>" size="30">
                    <p class="description" id="tagline-description">For example: demo.awardsplatform.com</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">API Key</th>
                <td>
                    <input type="text" name="award-force-sso-api-key" value="<?php echo get_option( 'award-force-sso-api-key' ); ?>" size="58" />
                    <p class="description" id="tagline-description">An Awards Manager can generate this key in Award Force (Settings > Developers > API keys)</p>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
        </p>
    </form>
</div>