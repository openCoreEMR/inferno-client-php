<?php

namespace OpenCoreEmr\InfernoClient\Models;

require_once 'BaseModel.php';
require_once 'Result.php';
require_once 'Input.php';

/**
 * Represents a TestRun response from the Inferno API
 */
class TestRun extends BaseModel
{
    /** @var string The ID of the test run */
    public $id;

    /** @var int The number of tests in this run */
    public $test_count;

    /** @var string The ID of the test session */
    public $test_session_id;

    /** @var string The ID of the test suite */
    public $test_suite_id;

    /** @var string The ID of the test group */
    public $test_group_id;

    /** @var string The ID of the test */
    public $test_id;

    /** @var Input[] Inputs for the test run */
    public $inputs = [];

    /** @var Result[] Results of the test run */
    public $results = [];

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data)
    {
        $instance = parent::fromArray($data);

        // Convert inputs to Input objects
        if (isset($data['inputs'])) {
            $instance->inputs = Input::fromArrayCollection($data['inputs']);
        }

        // Convert results to Result objects
        if (isset($data['results'])) {
            $instance->results = Result::fromArrayCollection($data['results']);
        }

        return $instance;
    }
}
