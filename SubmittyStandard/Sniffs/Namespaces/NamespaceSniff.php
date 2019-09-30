<?php

/**
 * Makes sure the namespace declared in each class file fits to the folder structure.
 *
 * @author    Matthew Peveler
 */

declare(strict_types=1);

namespace SubmittyStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NamespaceSniff implements Sniff {
    public function register(): array {
        return [T_NAMESPACE];
    }

    public function process(File $phpcs_file, $stack_ptr): void {
        $ptr_after_namespace = $phpcs_file->findEndOfStatement($stack_ptr + 1);
        $namespace = $phpcs_file->getTokensAsString($stack_ptr + 2, $ptr_after_namespace - ($stack_ptr + 2));
        if (strlen($namespace) === 0) {
            return;
        }
        if ($namespace[0] === '\\') {
            // Namespaces with leading slash are caught in another sniff
            return;
        }

        // scan upward from the file until we find the composer.json to give us our base
        $base_path = dirname($phpcs_file->path);
        while (($pos = strrpos($base_path, DIRECTORY_SEPARATOR)) !== false) {
            $base_path = substr($base_path, 0, $pos);
            if (is_file($base_path . DIRECTORY_SEPARATOR . "composer.json")) {
                break;
            }
        }

        $path = substr(dirname($phpcs_file->path), strlen($base_path) + 1);
        if (str_replace(DIRECTORY_SEPARATOR, '\\', $path) !== $namespace) {
            $error = sprintf('Namespace %s does not fit to folder structure %s', $namespace, $path);
            $phpcs_file->addError($error, $stack_ptr, 'NamespaceFolderMismatch');
        }
    }
}
