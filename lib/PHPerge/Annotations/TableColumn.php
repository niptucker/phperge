<?php

namespace PHPerge\Annotations;

/**
 * Verge table column annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class TableColumn {

    /**
     * Column name
     * @var string
     */
    public $columnName;
}
