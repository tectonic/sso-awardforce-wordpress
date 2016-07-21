<?php

use GuzzleHttp\Client;

class AwardForceAPI {

    private $apiUrl = 'https://api.awardsplatform.com';

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = get_option('award-force-sso-api-key');
    }

    /**
     * Sends a GET request to the Award Force API.
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, $options = [])
    {
        try {
            $response = $this->getClient()->post($uri, $options);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Retrieves the API access token from the database. If not available, requests it to the API.
     *
     * @return string
     */
    private function getAccessToken()
    {
        if ($token = get_option('award-force-access-token')) {
            return $token;
        }

        $token = $this->requestAccessToken();

        update_option('award-force-access-token', $token);

        return $token;
    }

    /**
     * Requests an access token to the Award Force API.
     *
     * @return string
     */
    private function requestAccessToken()
    {
        try {
            $client = new Client([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Accept' => 'application/vnd.Award Force.v1.0+json',
                    'Authorization' => 'Basic ' . $this->apiKey
                ],
            ]);

            $response = $client->get('/access-token');
            return $response->getBody()->getContents();
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
                'Accept' => 'application/vnd.Award Force.v1.0+json',
                'Authorization' => 'Basic ' . $this->getAccessToken()
            ],
        ]);
    }

    /**
     * Logs any potential errors, clears the API access token from the database and displays an error message to
     * the user.
     *
     * @param Exception $e
     */
    private function handleException(Exception $e)
    {
        delete_option('award-force-access-token');

        error_log('AWARD FORCE API ERROR: ' . $e->getMessage());

        wp_die('An error has occurred. Please try again, and if the problem persists, contact the system administrator.');
    }
}