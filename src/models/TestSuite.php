<?php

namespace OpenCoreEmr\InfernoClient\Models;

require_once 'BaseModel.php';
require_once 'TestGroup.php';
require_once 'Input.php';
require_once 'Message.php';
require_once 'PresetSummary.php';
require_once 'SuiteOption.php';

/**
 * Represents a TestSuite response from the Inferno API
 */
class TestSuite extends BaseModel
{
    /** @var string The ID of the test suite */
    public $id;

    /** @var string The title of the test suite */
    public $title;

    /** @var string The short title of the test suite */
    public $short_title;

    /** @var string The description of the test suite */
    public $description;

    /** @var string The short description of the test suite */
    public $short_description;

    /** @var string Instructions for the inputs of the test suite */
    public $input_instructions;

    /** @var array Links associated with the test suite */
    public $links = [];

    /** @var TestGroup[] Test groups in this suite */
    public $test_groups = [];

    /** @var Input[] Inputs for the test suite */
    public $inputs = [];

    /** @var int The number of tests in this suite */
    public $test_count;

    /** @var string The version of the test suite */
    public $version;

    /** @var Message[] Configuration messages for the test suite */
    public $configuration_messages = [];

    /** @var PresetSummary[] Presets available for this test suite */
    public $presets = [];

    /** @var SuiteOption[] Options for this test suite */
    public $suite_options = [];

    /** @var string A summary of the test suite */
    public $suite_summary;

    /** @var array Requirements verified by this test suite */
    public $verifies_requirements = [];

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data)
    {
        $instance = parent::fromArray($data);

        // Convert test groups to TestGroup objects
        if (isset($data['test_groups'])) {
            $instance->test_groups = TestGroup::fromArrayCollection($data['test_groups']);
        }

        // Convert inputs to Input objects
        if (isset($data['inputs'])) {
            $instance->inputs = Input::fromArrayCollection($data['inputs']);
        }

        // Convert configuration messages to Message objects
        if (isset($data['configuration_messages'])) {
            $instance->configuration_messages = Message::fromArrayCollection($data['configuration_messages']);
        }

        // Convert presets to PresetSummary objects
        if (isset($data['presets'])) {
            $instance->presets = PresetSummary::fromArrayCollection($data['presets']);
        }

        // Convert suite options to SuiteOption objects
        if (isset($data['suite_options'])) {
            $instance->suite_options = SuiteOption::fromArrayCollection($data['suite_options']);
        }

        return $instance;
    }
}
