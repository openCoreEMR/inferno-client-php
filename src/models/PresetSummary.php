<?php

namespace OpenCoreEmr\InfernoClient\Models;

/**
 * Represents a PresetSummary response from the Inferno API
 */
class PresetSummary extends BaseModel
{
    /** @var string The ID of the preset */
    public $id;

    /** @var string The title of the preset */
    public $title;
}
