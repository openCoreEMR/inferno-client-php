<?php

namespace OpenCoreEmr\InfernoClient\Models;

require_once 'BaseModel.php';
require_once 'Test.php';
require_once 'Input.php';

/**
 * Represents a TestGroup response from the Inferno API
 */
class TestGroup extends BaseModel
{
    /** @var string The ID of the test group */
    public $id;

    /** @var string The short ID of the test group */
    public $short_id;

    /** @var string The title of the test group */
    public $title;

    /** @var string The short title of the test group */
    public $short_title;

    /** @var string The description of the test group */
    public $description;

    /** @var string The short description of the test group */
    public $short_description;

    /** @var string Instructions for the inputs of the test group */
    public $input_instructions;

    /** @var bool Whether the group should be run as a single unit */
    public $run_as_group;

    /** @var TestGroup[] Nested test groups */
    public $test_groups = [];

    /** @var Test[] Tests in this group */
    public $tests = [];

    /** @var Input[] Inputs for the test group */
    public $inputs = [];

    /** @var int The number of tests in this group */
    public $test_count;

    /** @var bool Whether the test group can be run by users */
    public $user_runnable;

    /** @var bool Whether the test group is optional */
    public $optional;

    /** @var array Requirements verified by this test group */
    public $verifies_requirements = [];

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data)
    {
        $instance = parent::fromArray($data);

        // Convert nested test groups to TestGroup objects
        if (isset($data['test_groups'])) {
            $instance->test_groups = self::fromArrayCollection($data['test_groups']);
        }

        // Convert tests to Test objects
        if (isset($data['tests'])) {
            $instance->tests = Test::fromArrayCollection($data['tests']);
        }

        // Convert inputs to Input objects
        if (isset($data['inputs'])) {
            $instance->inputs = Input::fromArrayCollection($data['inputs']);
        }

        return $instance;
    }
}
