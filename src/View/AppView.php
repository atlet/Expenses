<?php

declare(strict_types=1);

namespace App\View;

use App\View\Helper\TablerFormHelper;
use Cake\View\View;

class AppView extends View {
    public function initialize(): void {
        $this->loadHelper('Flash', [
            'className' => 'BootstrapFlash'
        ]);

        $this->loadHelper('Form', [
            'className' => TablerFormHelper::class,
            'templates' => 'tabler_form',
        ]);
    }
}
