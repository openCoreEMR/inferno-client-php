<?php

require_once 'BaseModel.php';

/**
 * Represents a Version response from the Inferno API
 */
class Version extends BaseModel
{
    /** @var string The version of Inferno */
    public $version;
}
