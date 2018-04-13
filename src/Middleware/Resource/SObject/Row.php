<?php

namespace Flipbox\Relay\Salesforce\Middleware\Resource\SObject;

/**
 * Ref: https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_retrieve.htm
 */
class Row extends Basic
{
    /**
     * @var string
     */
    public $id;

    /**
     * @inheritdoc
     */
    protected function assemblePath(): string
    {
        $id = '';

        if (!empty($this->id)) {
            $id = $this->id . '/';
        }

        return parent::assemblePath() . $id;
    }
}
