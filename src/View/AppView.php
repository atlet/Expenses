<?php

declare(strict_types=1);

namespace App\View;

use Cake\View\View;

class AppView extends View {
    public function initialize(): void {
        $this->loadHelper('Flash', [
            'className' => 'BootstrapFlash'
        ]);
    }
}
