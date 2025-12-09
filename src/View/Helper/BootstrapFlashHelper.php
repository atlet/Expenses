<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper\FlashHelper;

class BootstrapFlashHelper extends FlashHelper {
    protected array $_defaultConfig = [
        'key' => 'flash',
        'element' => 'flash/default',
        'params' => [],
        'clear' => false,
        'duplicate' => true,
    ];

    public function render(string $key = 'flash', array $options = []): ?string {
        $options += ['element' => 'Flash/default'];

        return parent::render($key, $options);
    }
}
