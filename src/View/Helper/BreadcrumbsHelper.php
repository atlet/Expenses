<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

class BreadcrumbsHelper extends Helper {
    protected $helpers = ['Html'];

    public function render(array $items): string {
        if (empty($items)) {
            return '';
        }

        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

        $count = count($items);
        foreach ($items as $index => $item) {
            $isLast = ($index === $count - 1);

            if ($isLast) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . h($item['title']) . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item">';
                $html .= $this->Html->link($item['title'], $item['url']);
                $html .= '</li>';
            }
        }

        $html .= '</ol></nav>';

        return $html;
    }
}
