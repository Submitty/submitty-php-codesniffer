<?php
/**
 * Checks the naming of variables and member variables to be lowercase snakecase
 *
 * @author    Matthew Peveler
 */
namespace SubmittyStandard\Sniffs\NamingConventions;

use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Util\Common;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class ValidVariableNameSniff extends AbstractVariableSniff {
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    protected function processVariable(File $phpcsFile, $stackPtr) {
        $tokens  = $phpcsFile->getTokens();
        $varName = ltrim($tokens[$stackPtr]['content'], '$');
        // If it's a php reserved var, then its ok.
        if (isset($this->phpReservedVars[$varName]) === true) {
            return;
        }
        $objOperator = $phpcsFile->findNext([T_WHITESPACE], ($stackPtr + 1), null, true);
        if ($tokens[$objOperator]['code'] === T_OBJECT_OPERATOR) {
            // Check to see if we are using a variable from an object.
            $var = $phpcsFile->findNext([T_WHITESPACE], ($objOperator + 1), null, true);
            if ($tokens[$var]['code'] === T_STRING) {
                $bracket = $phpcsFile->findNext([T_WHITESPACE], ($var + 1), null, true);
                if ($tokens[$bracket]['code'] !== T_OPEN_PARENTHESIS) {
                    $objVarName = $tokens[$var]['content'];
                    if (preg_match('/[A-Z]/', $objVarName)) {
                        $phpcsFile->addError(
                            'Variable "%s" is not in valid snake_case format',
                            $var,
                            'NotSnakeCase',
                            [$objVarName]
                        );
                    }
                }
            }
        }

        if (preg_match('/[A-Z]/', $varName)) {
            $phpcsFile->addError(
                'Variable "%s" is not in valid snake_case format',
                $stackPtr,
                'NotSnakeCase',
                [$varName]
            );
        }
    }

    /**
     * Processes class member variables.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    protected function processMemberVar(File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $varName     = ltrim($tokens[$stackPtr]['content'], '$');
        $memberProps = $phpcsFile->getMemberProperties($stackPtr);
        if (empty($memberProps) === true) {
            // Couldn't get any info about this variable, which
            // generally means it is invalid or possibly has a parse
            // error. Any errors will be reported by the core, so
            // we can ignore it.
            return;
        }
        $public    = ($memberProps['scope'] !== 'private');
        $errorData = [$varName];
        if (preg_match('/[A-Z]/', $varName)) {
            $phpcsFile->addError(
                'Member variable "%s" is not in valid snake_case format',
                $stackPtr,
                'MemberNotSnakeCase',
                [$varName]
            );
        }
    }

    /**
     * Processes the variable found within a double quoted string.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the double quoted
     *                                               string.
     *
     * @return void
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        if (preg_match_all('|[^\\\]\${?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)|', $tokens[$stackPtr]['content'], $matches) !== 0) {
            foreach ($matches[1] as $varName) {
                // If it's a php reserved var, then its ok.
                if (isset($this->phpReservedVars[$varName]) === true) {
                    continue;
                }
                if (preg_match('/[A-Z]/', $varName)) {
                    $phpcsFile->addError(
                        'Variable "%s" is not in valid snake_case format',
                        $stackPtr,
                        'MemberNotSnakeCase',
                        [$varName]
                    );
                }
            }
        }
    }
}