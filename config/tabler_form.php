<?php

declare(strict_types=1);

return [
    // Wrapper okrog vsakega inputa (Tabler uporablja .mb-3 zelo pogosto)
    'inputContainer' => '<div class="mb-3 {{type}}{{required}}">{{content}}{{help}}</div>',
    'inputContainerError' => '<div class="mb-3 {{type}}{{required}} has-validation">{{content}}{{error}}{{help}}</div>',

    // Label
    'label' => '<label class="form-label"{{attrs}}>{{text}}</label>',

    // Basic inputi
    'input' => '<input type="{{type}}" name="{{name}}" class="form-control{{attrs.class}}"{{attrs}}/>',
    'textarea' => '<textarea name="{{name}}" class="form-control{{attrs.class}}"{{attrs}}>{{value}}</textarea>',
    'select' => '<select name="{{name}}" class="form-select{{attrs.class}}"{{attrs}}>{{content}}</select>',

    // Checkbox / radio (Tabler ima .form-check)
    'checkboxContainer' => '<label class="form-check">{{input}}<span class="form-check-label">{{label}}</span></label>',
    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}" class="form-check-input{{attrs.class}}"{{attrs}}>',
    'radioContainer' => '<div class="form-check">{{input}}<span class="form-check-label">{{label}}</span></div>',
    'radio' => '<input type="radio" name="{{name}}" value="{{value}}" class="form-check-input{{attrs.class}}"{{attrs}}>',

    // Errorji (Tabler/Bootstrap-like)
    'error' => '<div class="invalid-feedback d-block"{{attrs}}>{{content}}</div>',

    // Help text
    'help' => '<div class="form-hint">{{content}}</div>',

    // Submit gumb
    'submitContainer' => '<div class="mt-4">{{content}}</div>',
    'submit' => '<button type="submit" class="btn btn-primary{{attrs.class}}"{{attrs}}>{{text}}</button>',

    // “Form group” (fieldset/legend)
    'fieldset' => '<fieldset>{{content}}</fieldset>',
    'legend' => '<legend class="form-label mb-2">{{text}}</legend>',
];
