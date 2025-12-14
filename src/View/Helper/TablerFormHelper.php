<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Form\ContextInterface;
use Cake\View\Helper\FormHelper;
use Cake\View\View;

class TablerFormHelper extends FormHelper {
    public function __construct(View $view, array $config = []) {
        // varnost: če kdo pozabi templates v AppView, jih lahko še tu
        $config += [
            'templates' => 'tabler_form',
        ];

        parent::__construct($view, $config);
    }

    /**
     * Doda is-invalid + aria-invalid avtomatsko, ko polje vsebuje validation error.
     */
    public function control(string $fieldName, array $options = []): string {
        $hasError = $this->isFieldError($fieldName); // ✅ brez getContext()

        if ($hasError) {
            $type = $options['type'] ?? null;
            $isCheckLike = in_array($type, ['checkbox', 'radio'], true);

            if (!$isCheckLike) {
                $options['class'] = $this->appendClass($options['class'] ?? '', 'is-invalid');
            }

            $options['aria-invalid'] = 'true';
        }

        return parent::control($fieldName, $options);
    }

    /**
     * Override error(): obogati error output z id-jem (za aria-describedby)
     */
    public function error(string $field, array|string|null $text = null, array $options = []): string {
        $options += ['escape' => true];

        // če control dobi id=..., damo error id = {id}-error
        $controlId = $options['for'] ?? null;
        if ($controlId && !isset($options['id'])) {
            $options['id'] = $controlId . '-error';
        }

        return parent::error($field, $text, $options);
    }

    private function hasFieldError(string $fieldName): bool {
        $context = $this->getContext();

        if (!$context instanceof ContextInterface) {
            return false;
        }

        $errors = $context->getError($fieldName);

        return !empty($errors);
    }

    private function appendClass(string $existing, string $classToAdd): string {
        $existing = trim($existing);
        if ($existing === '') {
            return $classToAdd;
        }

        $parts = preg_split('/\s+/', $existing) ?: [];
        if (in_array($classToAdd, $parts, true)) {
            return $existing;
        }

        return $existing . ' ' . $classToAdd;
    }
}
