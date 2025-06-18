<?php

require_once 'BaseModel.php';

/**
 * Represents an Input response from the Inferno API
 */
class Input extends BaseModel
{
    /** @var string The name of the input */
    public $name;

    /** @var string The value of the input */
    public $value;

    /** @var string The title of the input */
    public $title;

    /** @var string The description of the input */
    public $description;

    /** @var boolean Whether the input is optional */
    public $optional;

    /** @var string The type of the input */
    public $type;

    /** @var boolean Whether the input is locked */
    public $locked;

    /** @var boolean Whether the input is hidden */
    public $hidden;

    /** @var array Options for the input */
    public $options;
}
