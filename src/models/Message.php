<?php

namespace OpenCoreEmr\InfernoClient\Models;

require_once 'BaseModel.php';

/**
 * Represents a Message response from the Inferno API
 */
class Message extends BaseModel
{
    /** @var string The type of message (error, warning, info) */
    public $type;

    /** @var string The message text */
    public $message;
}
