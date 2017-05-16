<?php

namespace PricePlan;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use Exceptions\PricePlanException;
// use Api\Product;

class PricePlanClient
{
    private $domain;

    private $login;

    private $password;

    private $auth;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    private $guzzle;
    /**
     * Create a new instance.
     *
     * @param  string $apiKey
     * @param  \GuzzleHttp\Client $guzzle
     * @return void
     */
    public function __construct($domain, HttpClient $guzzle = null)
    {
        $this->domain = $domain;
        // $this->login = $login;
        // $this->password = $password;

        $this->guzzle = $guzzle ?: new HttpClient([
            'base_uri' => 'https://'.$this->domain.'.priceplan.pro/api/',
            'cookies' => true,
            // 'http_errors' => false,
            // 'headers' => [
            //     'Authorization' => 'Bearer '.$this->apiKey,
            //     'Accept' => 'application/json',
            //     'Content-Type' => 'application/json'
            // ]
        ]);
    }

    public function withSessionAuthentication($user, $password)
    {
        $this->post('login', [
            'user' => $user,
            'password' => $password,
        ]);

        return $this;
    }

    public function withBasicAuthentication($apiKey, $password)
    {
        $this->auth = [$apiKey, $password];

        return $this;
    }

    public function withApiKeyAuthentication()
    {
        return $this;
    }

    /**
     * Make a GET request and return the response.
     *
     * @param  string $uri
     * @return mixed
     */
    public function get($uri, $query = [])
    {
        return $this->request('GET', $uri, [], [], $query);
    }

    /**
     * Make a POST request and return the response.
     *
     * @param  string $uri
     * @param  array $payload
     * @return mixed
     */
    public function post($uri, array $payload = [])
    {
        return $this->request('POST', $uri, [], $payload);
    }

    /**
     * Make a PUT request and return the response.
     *
     * @param  string $uri
     * @param  array $payload
     * @return mixed
     */
    public function put($uri, array $payload = [])
    {
        return $this->request('PUT', $uri, [], $payload);
    }

    /**
     * Make a DELETE request and return the response.
     *
     * @param  string $uri
     * @param  array $payload
     * @return mixed
     */
    public function delete($uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, [], $payload);
    }

    public function download($uri, $path)
    {
        return $this->request('GET', $uri, ['sink' => $path]);
    }

    /**
     * Make request and return the response.
     *
     * @param  string $verb
     * @param  string $uri
     * @param  array $payload
     * @return mixed
     */
    public function request($verb, $uri, array $headers = [], array $payload = [], array $query = [])
    {
        if ($this->auth) {
            $headers['auth'] = $this->auth;
        }
        if ($payload) {
            $headers['json'] = $payload;
        }
        if ($query) {
            $headers['query'] = $query;
        }

        $response = $this->guzzle->request($verb, $uri, $headers);
        if ($response->getStatusCode() != 200) {
            return $this->handleRequestError($response);
        }
        $responseBody = (string) $response->getBody();
        $responseBodyDecoded = json_decode($responseBody);

        if (isset($responseBodyDecoded->success)) {
            if ($responseBodyDecoded->success) {
                return $responseBodyDecoded->data ?? false;
            }
            return $this->handleRequestError($response);
        }
        return $responseBodyDecoded;

        // return json_decode($responseBody, true) ?: $responseBody;
    }

    public function api($name)
    {
        switch ($name) {
            case 'client':
            case 'clients':
                $api = new Api\Client($this);
                break;
            case 'document':
            case 'documents':
                $api = new Api\Document($this);
                break;
            case 'product':
            case 'products':
                $api = new Api\Product($this);
                break;
            case 'subscription':
            case 'subscriptions':
                $api = new Api\Subscription($this);
                break;
                
        }

        return $api;
    }

    /**
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @return void
     */
    private function handleRequestError(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 422) {
            // throw new ValidationException(json_decode((string) $response->getBody(), true));
            throw new \Exception((string) $response->getBody());
        }
        if ($response->getStatusCode() == 404) {
            // throw new NotFoundException();
            throw new \Exception((string) $response->getBody());
        }
        if ($response->getStatusCode() == 400) {
            // throw new FailedActionException((string) $response->getBody());
            throw new \Exception((string) $response->getBody());
        }
        if ($response->getStatusCode() == 200) {
            throw new Exceptions\PricePlanException((string) $response->getBody());
        }
        throw new \Exception((string) $response->getBody());
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param  array $collection
     * @param  string $class
     * @param  array $extraData
     * @return array
     */
    protected function transformCollection($collection, $class, $extraData = [])
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection);
    }

}

?>