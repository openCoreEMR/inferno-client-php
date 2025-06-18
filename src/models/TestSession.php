<?php

require_once 'BaseModel.php';
require_once 'TestSuite.php';
require_once 'TestRun.php';
require_once 'Result.php';
require_once 'SuiteOption.php';

/**
 * Represents a TestSession response from the Inferno API
 */
class TestSession extends BaseModel
{
    /** @var string The ID of the test session */
    public $id;

    /** @var TestSuite The test suite of this session */
    public $test_suite;

    /** @var TestRun The current test run of this session */
    public $test_run;

    /** @var Result[] Results of this session */
    public $results = [];

    /** @var SuiteOption[] Options for this session */
    public $suite_options = [];

    /** @var string The ID of the test suite */
    public $test_suite_id;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data)
    {
        $instance = parent::fromArray($data);

        // Convert test suite to TestSuite object
        if (isset($data['test_suite'])) {
            $instance->test_suite = TestSuite::fromArray($data['test_suite']);
        }

        // Convert test run to TestRun object
        if (isset($data['test_run'])) {
            $instance->test_run = TestRun::fromArray($data['test_run']);
        }

        // Convert results to Result objects
        if (isset($data['results'])) {
            $instance->results = Result::fromArrayCollection($data['results']);
        }

        // Convert suite options to SuiteOption objects
        if (isset($data['suite_options'])) {
            $instance->suite_options = SuiteOption::fromArrayCollection($data['suite_options']);
        }

        return $instance;
    }
}
