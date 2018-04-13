<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource\SObject;

/**
 * Ref: https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_describe.htm
 */
class Describe extends Basic
{
    /**
     * @inheritdoc
     */
    protected function assemblePath(): string
    {
        return parent::assemblePath() . 'describe/';
    }
}
