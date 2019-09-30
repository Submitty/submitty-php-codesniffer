<?php

namespace SubmittyStandard\Tests\Namespaces;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class NamespaceUnitTest extends AbstractSniffUnitTest {
    public function getErrorList($test_file = '') {
        switch ($test_file) {
            case 'NamespaceUnitTest.1.inc':
                return [];
            default:
                return [3 => 1];
        }
    }

    public function getWarningList() {
        return [];
    }
}
