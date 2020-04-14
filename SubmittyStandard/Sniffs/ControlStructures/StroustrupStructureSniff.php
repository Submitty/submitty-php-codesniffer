<?php

/**
 * Verifies that control statements conform to their coding standards.
 *
 * @author    Matthew Peveler
 */

declare(strict_types=1);

namespace SubmittyStandard\Sniffs\ControlStructures;

use PHPCSExtra\Universal\Sniffs\ControlStructures\IfElseDeclarationSniff;

class StroustrupStructureSniff extends IfElseDeclarationSniff {
    public function register() {
        return [
            \T_ELSE,
            \T_ELSEIF,
            \T_CATCH
        ];
    }
}
