<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce;

use Psr\Http\Message\RequestInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
interface InstanceInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareInstanceRequest(RequestInterface $request): RequestInterface;
}
