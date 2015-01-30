<?php

namespace PHPerge\Annotations;

/**
 * Verge table annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 * @Attributes({
 *     @Attribute("id", type = "string"),
 *     @Attribute("rowClass", type = "string")
 * })
 */
class Table {

    /**
     * Table id
     * @var string
     */
    public $id;

    /**
     * Table Class
     * @var string
     */
    public $rowClass;

}
