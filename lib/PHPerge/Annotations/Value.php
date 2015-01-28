<?php

namespace PHPerge\Annotations;

/**
 * Verge enum field value annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 * @Attributes({
 *     @Attribute("key", type = "string"),
 *     @Attribute("value", type = "string")
 * })
 */
class Value {
    /**
     * Enum key
     * @var string
     */
    public $key;

    /**
     * Enum value
     * @var string
     */
    public $value;
}
