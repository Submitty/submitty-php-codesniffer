<?php

namespace SubmittyStandard\Tests\ControlStructures;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class DoWhileUnitTest extends AbstractSniffUnitTest {
    public function getErrorList() {
        return [
            8 => 1,
            9 => 1
        ];
    }

    public function getWarningList() {
        return [];
    }
}
