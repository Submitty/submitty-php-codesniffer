<?php
/**
 * Verifies that control statements conform to their coding standards.
 *
 * @author    Matthew Peveler
 */

namespace SubmittyStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Sniffs\AbstractPatternSniff;

class StroustrupStructureSniff extends AbstractPatternSniff {
    /**
     * If true, comments will be ignored if they are found in the code.
     *
     * @var boolean
     */
    public $ignoreComments = true;

    protected function getPatterns() {
        return [
            'do {EOL...} while (...);EOL',
            'while (...) {EOL',
            'for (...) {EOL',
            'if (...) {EOL',
            'foreach (...) {EOL',
            '}EOLelse if (...) {EOL',
            '}EOLelseif (...) {EOL',
            '}EOLelse {EOL',
            'do {EOL',
        ];
    }
}