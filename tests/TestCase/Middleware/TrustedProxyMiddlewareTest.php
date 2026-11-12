<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\TrustedProxyMiddleware;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrustedProxyMiddlewareTest extends TestCase
{
    public function testForwardedSchemeRequiresExplicitPeerIp(): void
    {
        $previous = getenv('TRUSTED_PROXIES');
        putenv('TRUSTED_PROXIES=10.0.0.1, 10.0.0.3');
        try {
            $handler = new class implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    return (new Response())->withHeader('X-Scheme', $request->getUri()->getScheme());
                }
            };
            foreach (['10.0.0.1' => 'https', '10.0.0.2' => 'http', '10.0.0.3' => 'https'] as $ip => $scheme) {
                $request = new ServerRequest([
                    'url' => 'http://localhost/',
                    'environment' => ['REMOTE_ADDR' => $ip, 'HTTP_X_FORWARDED_PROTO' => 'https'],
                ]);
                $response = (new TrustedProxyMiddleware())->process($request, $handler);
                $this->assertSame($scheme, $response->getHeaderLine('X-Scheme'));
                $this->assertFalse($request->trustProxy, 'Original request must stay unchanged');
            }
        } finally {
            putenv($previous === false ? 'TRUSTED_PROXIES' : 'TRUSTED_PROXIES=' . $previous);
        }
    }
}
