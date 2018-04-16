<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce\Middleware;

use Flipbox\Relay\Middleware\AbstractMiddleware;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Client extends AbstractMiddleware
{
    /**
     * @inheritdoc
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        parent::__invoke($request, $response, $next);

        $request = $this->prepRequest($request);
        $response = $this->call($request, $response);
        return $next($request, $response);
    }

    /**
     * Call the API
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function call(RequestInterface $request, ResponseInterface $response)
    {
        try {
            $this->info(
                "SALESFORCE API REQUEST - URI: {uri}, METHOD: {method}, PAYLOAD: {payload}",
                [
                    'uri' => $request->getUri(),
                    'method' => $request->getMethod(),
                    'payload' => $request->getBody()
                ]
            );

            $httpResponse = (new GuzzleHttpClient())
                ->send($request);
        } catch (ClientException $e) {
            $this->error(
                "API Exception",
                [
                    'exception' => $e
                ]
            );
            $httpResponse = $e->getResponse();
        }
        
        // Sync responses
        if ($httpResponse !== null) {
            $response = $this->syncResponse($httpResponse, $response);
        }

        return $response;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function prepRequest(RequestInterface $request)
    {
        return $request->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');
    }

    /**
     * @param ResponseInterface $httpResponse
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function syncResponse(ResponseInterface $httpResponse, ResponseInterface $response)
    {
        // Add headers
        foreach ($httpResponse->getHeaders() as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        return $response->withStatus($httpResponse->getStatusCode(), $httpResponse->getReasonPhrase())
            ->withBody($httpResponse->getBody())
            ->withProtocolVersion($httpResponse->getProtocolVersion());
    }
}
