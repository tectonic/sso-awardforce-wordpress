<?php

use GuzzleHttp\Client;

class AwardForceAPIV2 {

    private $apiUrl = 'https://api.cr4ce.com';

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = get_option('award-force-sso-api-key');
    }

    /**
     * Sends a GET request to the Award Force API
     *
     * @param $uri
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, $options = [])
    {
        try {
            $response = $this->getClient()->get($uri, $options);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Sends a POST request to the Award Force API.
     *
     * @param $uri
     * @param array $options
     *
     * @return string
     */
    public function post($uri, $options = [])
    {
        try {
            $response = $this->getClient()->post($uri, ['json' => $options]);
            if ($response->getStatusCode() == 201) {
                return (object)['slug' => substr((string)$response->getHeader('Location')[0], -8)];
            }
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Returns an instance of an HTTP Client.
     *
     * @return Client
     */
    private function getClient()
    {
        return new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Accept' => 'application/vnd.Creative Force.v2.0+json',
                'x-api-key' => $this->apiKey,
            ],
            'http_errors' => false,
        ]);
    }

    /**
     * Logs any potential errors, clears the API access token from the database and displays an error message to
     * the user.
     *
     * @param Exception $e
     */
    public function handleException(Exception $e)
    {
        delete_option('award-force-access-token');

        error_log('AWARD FORCE API ERROR: ' . $e->getMessage());

        wp_die('An error has occurred. Please try again, and if the problem persists, contact the system administrator.');
    }
}
