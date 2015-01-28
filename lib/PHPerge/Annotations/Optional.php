<?php

namespace PHPerge\Annotations;

/**
 * Verge optional field annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 * @Attributes({
 *     @Attribute("default", type = "string")
 * })
 */
class Optional {

    /**
     * Default value for optional field
     * @var string
     */
    public $default;
}
