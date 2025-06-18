<?php

require_once 'BaseModel.php';
require_once 'Message.php';

/**
 * Represents a RequestSummary response from the Inferno API
 */
class RequestSummary extends BaseModel
{
    /** @var string The ID of the request */
    public $id;

    /** @var int The index of the request */
    public $index;

    /** @var string When the request was created */
    public $created_at;

    /** @var string The HTTP verb used in the request */
    public $verb;

    /** @var string The URL of the request */
    public $url;

    /** @var string The direction of the request (in, out) */
    public $direction;

    /** @var int The HTTP status code of the response */
    public $status;

    /** @var string The ID of the result associated with this request */
    public $result_id;
}
