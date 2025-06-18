<?php

namespace OpenCoreEmr\InfernoClient\Models;

/**
 * Base model class for all Inferno API models
 */
abstract class BaseModel
{
    /**
     * Constructor for the BaseModel
     *
     * This constructor is declared as final to prevent child classes from modifying
     * its signature. Altering the signature would break the `new static()` call
     * in the `fromArray()` method.
     */
    final public function __construct()
    {

    }

    /**
     * Create a new model instance from an array of data
     *
     * @param array $data The data to populate the model with
     * @return static The populated model
     */
    public static function fromArray(array $data)
    {
        $instance = new static();

        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }

    /**
     * Create a collection of models from an array of data
     *
     * @param array $dataArray The array of data to create models from
     * @return array The array of model instances
     */
    public static function fromArrayCollection(array $dataArray): array
    {
        $collection = [];

        foreach ($dataArray as $data) {
            $collection[] = static::fromArray($data);
        }

        return $collection;
    }
}
