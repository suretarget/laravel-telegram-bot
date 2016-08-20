<?php

namespace SumanIon\TelegramBot\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

trait SendsApiRequests
{
    use ManagesApiMethods;

    /**
     * Get the url where to send Telegram API requests.
     *
     * @return string
     */
    public function getApiUrl():string
    {
        return "https://api.telegram.org/bot{$this->token()}";
    }

    /**
     * Send an API request to Telegram.
     *
     * @param  string $method
     * @param  array  $options
     *
     * @return stdClass|null
     */
    public function sendRequest(string $method, array $options = [])
    {
        $options = http_build_query($options);
        $url     = "{$this->getApiUrl()}/{$method}?{$options}";
        $client  = new Client(['http_errors' => false]);

        return $this->getResponse($client->get($url));
    }

    /**
     * Send an POST API request to Telegram.
     *
     * @param  string $method
     * @param  array  $fields
     * @param  array  $options
     *
     * @return stdClass|null
     */
    public function sendPostRequest(string $method, array $fields = [], array $options = [])
    {
        $options = http_build_query($options);
        $url     = "{$this->getApiUrl()}/{$method}?{$options}";
        $client  = new Client(['http_errors' => false]);

        $response = $client->request('POST', $url, $fields);

        return $this->getResponse($response);
    }

    /**
     * Get the response from the API request.
     *
     * @param  Response $response
     *
     * @return stdClass|null
     */
    public function getResponse(Response $response)
    {
        $body = (string)$response->getBody();
        $body = json_decode($body);

        if (!isset($body->ok) or $body->ok !== true) {
            return $this->log($body, 'api');
        }

        $this->log(null, 'api');
        return $body;
    }

    /**
     * Get last API error if any.
     *
     * @return mixed
     */
    public function getLastApiError()
    {
        return $this->getLog('api');
    }
}