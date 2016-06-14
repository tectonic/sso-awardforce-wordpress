<?php

use GuzzleHttp\Client;

class AwardForceAPI {

    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = get_option('award-force-sso-api-url');
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
            return $this->getClient()->get($uri, $options);
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
            return $this->getClient()->post($uri, $options);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * Extracts the Award Force account id from the API key.
     *
     * @return string
     */
    private function getAccountId()
    {
        return substr($this->apiKey, 0, strpos($this->apiKey, '-'));
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
                'Authorization' => 'Basic ' . $this->getAccessToken(),
                'X-Account-Id' => $this->getAccountId(),
            ],
        ]);
    }

    /**
     * Logs any potential errors and displays a message to the user. If the error is a '401 Unauthorized', the access
     * token is cleared from the database.
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