<?php

namespace OpenCoreEmr\InfernoClient\Models;

/**
 * Represents a SuiteOption response from the Inferno API
 */
class SuiteOption extends BaseModel
{
    /** @var string The ID of the suite option */
    public $id;

    /** @var string The title of the suite option */
    public $title;

    /** @var string The default value of the suite option */
    public $default;

    /** @var string The description of the suite option */
    public $description;

    /** @var string The value of the suite option */
    public $value;

    /** @var array List options for the suite option */
    public $list_options;
}
