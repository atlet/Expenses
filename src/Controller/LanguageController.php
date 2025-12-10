<?php

declare(strict_types=1);

namespace App\Controller;

class LanguageController extends AppController {
    public function switch() {
        $this->request->allowMethod(['post', 'get']);

        $locale = $this->request->getQuery('locale');

        if (in_array($locale, ['en_US', 'sl_SI'])) {
            $this->request->getSession()->write('locale', $locale);
        }

        return $this->redirect($this->referer());
    }
}
