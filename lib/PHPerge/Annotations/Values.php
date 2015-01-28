<?php

namespace PHPerge\Annotations;

/**
 * Verge enum field values annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Values {
    /**
     * Enum values
     * @var array
     */
    public $values;
}
