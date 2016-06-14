<?php

class AwardForceSSO {

    private $api;
    private $installationUrl;

    public function __construct(AwardForceAPI $api)
    {
        $this->api = $api;
        $this->installationUrl = get_option('award-force-sso-installation-url');
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

        wp_redirect($this->installationUrl . '/login?token=' . $token);
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
        $response = $this->api->post('/user', [
            'form_params' => [
                'email'     => $user->user_email,
                'firstName' => $user->user_firstname ?: 'First',
                'lastName'  => $user->user_lastname ?: 'Last'
            ]
        ]);

        $body = json_decode($response->getBody()->getContents());

        return $body->slug;
    }

    /**
     * Sends a GET request to the Award Force API to obtain an authentication token for the user with the given slug.
     *
     * @param $slug
     * @return mixed
     */
    private function requestAuthToken($slug)
    {
        $response = $this->api->get('/user/' . $slug . '/auth-token');

        $body = json_decode($response->getBody()->getContents());

        return $body->auth_token;
    }
}