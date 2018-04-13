<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource\SObject;

use Flipbox\Relay\Salesforce\Middleware\Resource;

/**
 * Ref: https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_basic_info.htm
 */
class Basic extends Resource
{
    /**
     * The resource name
     */
    public $resource = 'sobjects';

    /**
     * @var string
     */
    public $sobject;

    /**
     * @inheritdoc
     */
    protected function assemblePath(): string
    {
        return parent::assemblePath() . $this->sobject . '/';
    }
}
