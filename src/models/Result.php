<?php

namespace OpenCoreEmr\InfernoClient\Models;

require_once 'BaseModel.php';
require_once 'Message.php';
require_once 'RequestSummary.php';
require_once 'SessionData.php';

/**
 * Represents a Result response from the Inferno API
 */
class Result extends BaseModel
{
    /** @var string The ID of the result */
    public $id;

    /** @var string The ID of the test suite */
    public $test_suite_id;

    /** @var string The ID of the test group */
    public $test_group_id;

    /** @var string The ID of the test */
    public $test_id;

    /** @var string The result status (pass, fail, skip, omit, error, running, wait, cancel) */
    public $result;

    /** @var string The ID of the test run */
    public $test_run_id;

    /** @var string The result message */
    public $result_message;

    /** @var string When the result was created */
    public $created_at;

    /** @var string When the result was last updated */
    public $updated_at;

    /** @var Message[] Messages associated with the result */
    public $messages = [];

    /** @var RequestSummary[] Requests associated with the result */
    public $requests = [];

    /** @var SessionData[] Outputs associated with the result */
    public $outputs = [];

    /** @var bool Whether the test is optional */
    public $optional;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data)
    {
        $instance = parent::fromArray($data);

        // Convert messages to Message objects
        if (isset($data['messages'])) {
            $instance->messages = Message::fromArrayCollection($data['messages']);
        }

        // Convert requests to RequestSummary objects
        if (isset($data['requests'])) {
            $instance->requests = RequestSummary::fromArrayCollection($data['requests']);
        }

        // Convert outputs to SessionData objects
        if (isset($data['outputs'])) {
            $instance->outputs = SessionData::fromArrayCollection($data['outputs']);
        }

        return $instance;
    }
}
