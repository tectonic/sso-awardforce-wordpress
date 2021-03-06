<?php

class AwardForceSSO {

    private $api;
    private $installationDomain;

    public function __construct(AwardForceAPIV2 $api)
    {
        $this->api = $api;
        $this->installationDomain = get_option('award-force-sso-installation-domain');
    }

    /**
     * Requests an Award Force authentication token and redirects the user to the awards homepage.
     *
     */
    public function sso()
    {
        if (!is_user_logged_in()) {
            wp_redirect(home_url());
            exit;
        }

        $slug = $this->getSlug(wp_get_current_user());

        $token = $this->requestAuthToken($slug);

        wp_redirect( "https://{$this->installationDomain}/login?token={$token}" );
        exit;
    }

    /**
     * Returns the Award Force slug of a user.
     *
     * @param WP_User $user
     * @return mixed
     */
    private function getSlug(WP_User $user)
    {
        if ($slug = get_user_meta($user->ID, 'award-force-slug', true)) {
            return $slug;
        }

        $slug = $this->requestSlug($user);

        update_user_meta($user->ID, 'award-force-slug', $slug);

        return $slug;
    }

    /**
     * Sends a POST request to the Award Force API to obtain the user's slug.
     *
     * @param WP_User $user
     * @return mixed
     */
    private function requestSlug(WP_User $user)
    {
        $response = $this->requestSlugByEmail($user->user_email);

        if ($response->slug) {
            return $response->slug;
        }

        $response = $this->api->post('/user', [
            'email' => $user->user_email,
            'first_name' => $user->user_firstname ?: 'First',
            'last_name' => $user->user_lastname ?: 'Last',
            'password' => uniqid(),
        ]);

        return $response->slug;
    }

    private function requestSlugByEmail($email)
    {
        return $this->api->get("user/" . $email);
    }

    /**
     * Sends a GET request to the Award Force API to obtain an authentication token for the user with the given slug.
     *
     * @param $slug
     * @return mixed
     */
    private function requestAuthToken($slug)
    {
        $retries = 5;
        while ($retries > 0) {
            $response = $this->api->get('/user/' . $slug . '/auth-token');
            if ($token = $response->auth_token) {
                return $token;
            }

            sleep(1);
            $retries--;
        }
    }
}