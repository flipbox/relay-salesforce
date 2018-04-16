<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-salesforce/blob/master/LICENSE.md
 * @link       https://github.com/flipbox/relay-salesforce
 */

namespace Flipbox\Relay\Salesforce\Middleware\Resource\SObject;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 *
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
