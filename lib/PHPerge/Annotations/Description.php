<?php

namespace PHPerge\Annotations;

/**
 * Verge template and field description annotation
 *
 * @Annotation
 * @Target({"CLASS", "METHOD", "PROPERTY"})
 */
class Description {
    /**
     * @var string
     */
    public $description;
}
