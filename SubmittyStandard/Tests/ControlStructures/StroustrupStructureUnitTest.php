<?php

namespace SubmittyStandard\Tests\ControlStructures;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class StroustrupStructureUnitTest extends AbstractSniffUnitTest {
    public function getErrorList() {
        return [
            4 => 1,
            5 => 1,
            6 => 1,
            20 => 1
        ];
    }

    public function getWarningList() {
        return [];
    }
}
