<?php

namespace OpenCoreEmr\InfernoClient\Models;

require_once 'BaseModel.php';
require_once 'RequestSummary.php';

/**
 * Represents a Request response from the Inferno API
 */
class Request extends RequestSummary
{
    /** @var array Request headers */
    public $request_headers;

    /** @var array Response headers */
    public $response_headers;

    /** @var string The request body */
    public $request_body;

    /** @var string The response body */
    public $response_body;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data)
    {
        $instance = parent::fromArray($data);

        // Process headers into a more usable format
        if (isset($data['request_headers'])) {
            $instance->request_headers = $data['request_headers'];
        }

        if (isset($data['response_headers'])) {
            $instance->response_headers = $data['response_headers'];
        }

        return $instance;
    }
}
