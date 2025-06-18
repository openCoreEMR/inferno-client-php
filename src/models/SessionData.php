<?php

namespace OpenCoreEmr\InfernoClient\Models;

/**
 * Represents a SessionData response from the Inferno API
 */
class SessionData extends BaseModel
{
    /** @var string The name of the session data */
    public $name;

    /** @var string The value of the session data */
    public $value;
}
