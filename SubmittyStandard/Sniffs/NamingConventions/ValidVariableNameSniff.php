<?php

/**
 * Checks the naming of variables and member variables to be lowercase snakecase
 *
 * @author    Matthew Peveler
 */

declare(strict_types=1);

namespace SubmittyStandard\Sniffs\NamingConventions;

use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Files\File;

class ValidVariableNameSniff extends AbstractVariableSniff {
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcs_file The file being scanned.
     * @param int                         $stack_ptr  The position of the current token in the
     *                                                stack passed in $tokens.
     *
     * @return void
     */
    protected function processVariable(File $phpcs_file, $stack_ptr) {
        $tokens  = $phpcs_file->getTokens();
        $var_name = ltrim($tokens[$stack_ptr]['content'], '$');
        // If it's a php reserved var, then its ok.
        // phpcs:disable SubmittyStandard.NamingConventions.ValidVariableName.NotSnakeCase
        if (isset($this->phpReservedVars[$var_name]) === true) {
            return;
        }
        // phpcs:enable
        $obj_operator = $phpcs_file->findNext([T_WHITESPACE], ($stack_ptr + 1), null, true);
        if ($tokens[$obj_operator]['code'] === T_OBJECT_OPERATOR) {
            // Check to see if we are using a variable from an object.
            $var = $phpcs_file->findNext([T_WHITESPACE], ($obj_operator + 1), null, true);
            if ($tokens[$var]['code'] === T_STRING) {
                $bracket = $phpcs_file->findNext([T_WHITESPACE], ($var + 1), null, true);
                if ($tokens[$bracket]['code'] !== T_OPEN_PARENTHESIS) {
                    $obj_var_name = $tokens[$var]['content'];
                    if (preg_match('/[A-Z]/', $obj_var_name)) {
                        $phpcs_file->addError(
                            'Variable "%s" is not in valid snake_case format',
                            $var,
                            'NotSnakeCase',
                            [$obj_var_name]
                        );
                    }
                }
            }
        }

        if (preg_match('/[A-Z]/', $var_name)) {
            $phpcs_file->addError(
                'Variable "%s" is not in valid snake_case format',
                $stack_ptr,
                'NotSnakeCase',
                [$var_name]
            );
        }
    }

    /**
     * Processes class member variables.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcs_file The file being scanned.
     * @param int                         $stack_ptr  The position of the current token in the
     *                                                stack passed in $tokens.
     *
     * @return void
     */
    protected function processMemberVar(File $phpcs_file, $stack_ptr) {
        $tokens = $phpcs_file->getTokens();
        $var_name = ltrim($tokens[$stack_ptr]['content'], '$');
        if (preg_match('/[A-Z]/', $var_name)) {
            $phpcs_file->addError(
                'Member variable "%s" is not in valid snake_case format',
                $stack_ptr,
                'MemberNotSnakeCase',
                [$var_name]
            );
        }
    }

    /**
     * Processes the variable found within a double quoted string.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcs_file The file being scanned.
     * @param int                         $stack_ptr  The position of the double quoted
     *                                                string.
     *
     * @return void
     */
    protected function processVariableInString(File $phpcs_file, $stack_ptr) {
        $tokens = $phpcs_file->getTokens();
        $pattern = '|[^\\\]\${?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)|';
        if (preg_match_all($pattern, $tokens[$stack_ptr]['content'], $matches) !== 0) {
            foreach ($matches[1] as $var_name) {
                // If it's a php reserved var, then its ok.
                // phpcs:disable SubmittyStandard.NamingConventions.ValidVariableName.NotSnakeCase
                if (isset($this->phpReservedVars[$var_name]) === true) {
                    continue;
                }
                // phpcs: enable
                if (preg_match('/[A-Z]/', $var_name)) {
                    $phpcs_file->addError(
                        'Variable "%s" is not in valid snake_case format',
                        $stack_ptr,
                        'MemberNotSnakeCase',
                        [$var_name]
                    );
                }
            }
        }
    }
}
