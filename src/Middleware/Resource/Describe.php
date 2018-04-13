<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource;

use Flipbox\Relay\Salesforce\Middleware\Resource;

/**
 * Class Describe
 * @package Flipbox\Relay\Salesforce\Middleware\SObject
 *
 * Ref: https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_describeGlobal.htm
 */
class Describe extends Resource
{
    /**
     * @inheritdoc
     */
    protected function assemblePath(): string
    {
        return parent::assemblePath() . 'describe/';
    }
}
