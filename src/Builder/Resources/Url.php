<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce\Builder\Resources;

use Flipbox\Relay\Middleware\SimpleCache as CacheMiddleware;
use Flipbox\Relay\Salesforce\AuthorizationInterface;
use Flipbox\Relay\Salesforce\Builder\HttpRelayBuilder;
use Flipbox\Relay\Salesforce\InstanceInterface;
use Flipbox\Relay\Salesforce\Middleware\Url as UrlMiddleware;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Url extends HttpRelayBuilder
{
    /**
     * Upsert constructor.
     * @param InstanceInterface $instance
     * @param AuthorizationInterface $authorization
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @param array $config
     */
    public function __construct(
        InstanceInterface $instance,
        AuthorizationInterface $authorization,
        CacheInterface $cache,
        string $url,
        LoggerInterface $logger = null,
        $config = []
    ) {
        parent::__construct($instance, $authorization, $logger, $config);

        $this->addUri($url, $logger)
            ->addCache($cache, $logger);
    }

    /**
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addUri(string $url, LoggerInterface $logger = null)
    {
        return $this->addAfter('uri', [
            'class' => UrlMiddleware::class,
            'url' => $url,
            'logger' => $logger ?: $this->getLogger()
        ], 'instance');
    }

    /**
     * @param CacheInterface $cache
     * @param LoggerInterface|null $logger
     * @return $this
     */
    protected function addCache(CacheInterface $cache, LoggerInterface $logger = null)
    {
        return $this->addBefore('cache', [
            'class' => CacheMiddleware::class,
            'logger' => $logger ?: $this->getLogger(),
            'cache' => $cache
        ], 'token');
    }
}
