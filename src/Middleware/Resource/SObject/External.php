<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource\SObject;

/**
 * Ref: https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_upsert.htm
 */
class External extends Basic
{
    /**
     * @var string
     */
    public $fieldName;

    /**
     * @var string
     */
    public $fieldValue;

    /**
     * @inheritdoc
     */
    protected function assemblePath(): string
    {
        return parent::assemblePath() . $this->fieldName . '/' . $this->fieldValue . '/';
    }
}
