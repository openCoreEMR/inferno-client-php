<?php

require_once 'BaseModel.php';
require_once 'Input.php';

/**
 * Represents a Test response from the Inferno API
 */
class Test extends BaseModel
{
    /** @var string The ID of the test */
    public $id;

    /** @var string The short ID of the test */
    public $short_id;

    /** @var string The title of the test */
    public $title;

    /** @var string The short title of the test */
    public $short_title;

    /** @var string The description of the test */
    public $description;

    /** @var string The short description of the test */
    public $short_description;

    /** @var string Instructions for the inputs of the test */
    public $input_instructions;

    /** @var Input[] Inputs for the test */
    public $inputs = [];

    /** @var bool Whether the test can be run by users */
    public $user_runnable;

    /** @var bool Whether the test is optional */
    public $optional;

    /** @var array Requirements verified by this test */
    public $verifies_requirements = [];

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

        return $instance;
    }
}
