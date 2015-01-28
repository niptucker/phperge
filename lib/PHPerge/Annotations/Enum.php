<?php

namespace PHPerge\Annotations;

/**
 * Verge enum field annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Enum {
    /**
     * Field name
     * @var string
     */
    public $fieldName;
}
