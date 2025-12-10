<?php

declare(strict_types=1);

namespace App\Middleware;

use Cake\I18n\I18n;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocaleSelectorMiddleware implements MiddlewareInterface {
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Preveri session
        $session = $request->getAttribute('session');
        $locale = $session->read('locale');

        // Če ni v sessioni, uporabi browser preference
        if (!$locale) {
            $locale = $this->detectLocaleFromBrowser($request);
        }

        // Nastavi locale
        I18n::setLocale($locale);

        return $handler->handle($request);
    }

    private function detectLocaleFromBrowser(ServerRequestInterface $request): string {
        $acceptLanguage = $request->getHeaderLine('Accept-Language');

        // Če browser preferira slovenščino
        if (stripos($acceptLanguage, 'sl') !== false) {
            return 'sl_SI';
        }

        return 'en_US'; // default
    }
}
