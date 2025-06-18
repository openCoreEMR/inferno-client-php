<?php

namespace OpenCoreEmr\InfernoClient\Models;

/**
 * Represents a Requirement response from the Inferno API
 */
class Requirement extends BaseModel
{
    /** @var string The ID of the requirement */
    public $id;

    /** @var string The requirement text */
    public $requirement;

    /** @var string The conformance level of the requirement */
    public $conformance;

    /** @var string The actor the requirement applies to */
    public $actor;

    /** @var string The conditionality of the requirement */
    public $conditionality;

    /** @var string The URL to more information about the requirement */
    public $url;

    /** @var array Sub-requirements */
    public $sub_requirements = [];
}
