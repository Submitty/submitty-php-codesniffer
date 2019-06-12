<?php

namespace SubmittyStandard\Tests\NamingConventions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ValidVariableNameUnitTest extends AbstractSniffUnitTest {
    public function getErrorList() {
        return [
            3 => 1,
            8 => 1,
            12 => 1,
            16 => 1,
            20 => 1,
            25 => 1,
            29 => 1,
            32 => 1,
            36 => 1,
            46 => 1,
            50 => 1,
            53 => 1,
            58 => 1,
            60 => 1,
            68 => 1,
            72 => 1
        ];
    }

    public function getWarningList() {
        return [];
    }
}
