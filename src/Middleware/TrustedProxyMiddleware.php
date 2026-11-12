<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrustedProxyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request instanceof ServerRequest) {
            $request = clone $request;
            $proxies = array_filter(array_map('trim', explode(',', (string)env('TRUSTED_PROXIES', ''))));
            $request->setTrustedProxies(array_values($proxies));
        }

        return $handler->handle($request);
    }
}
