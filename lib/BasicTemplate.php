<?php

namespace PHPerge;

use PHPerge\PdfRenderer;

class BasicTemplate implements ITemplate {
    public function render($connectionOptions) {
        return (new PdfRenderer($this, $connectionOptions))->render();
    }
}
