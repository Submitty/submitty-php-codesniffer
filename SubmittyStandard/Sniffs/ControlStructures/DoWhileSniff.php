<?php

/**
 * Verifies that control statements conform to their coding standards.
 *
 * @author    Matthew Peveler
 */

declare(strict_types=1);

namespace SubmittyStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ControlSignatureSniff;

class DoWhileSniff extends ControlSignatureSniff {
    public function register() {
        return [
            T_WHILE
        ];
    }
}
