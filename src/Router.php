<?php

namespace App;

use App\Http\Request;

class Router
{
    /** @var array<string, callable> */
    private array $getRoutes = [];

    /** @var array<string, callable> */
    private array $postRoutes = [];

    public function get(string $path, callable $handler): void
    {
        $this->getRoutes[$this->normalize($path)] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->postRoutes[$this->normalize($path)] = $handler;
    }

    public function dispatch(Request $request): mixed
    {
        $path = $request->getPath();
        $method = $request->getMethod();
        $routes = $method === 'POST' ? $this->postRoutes : $this->getRoutes;

        if (array_key_exists($path, $routes)) {
            return $routes[$path]($request);
        }

        http_response_code(404);
        return 'Stránka nebyla nalezena';
    }

    private function normalize(string $path): string
    {
        $normalized = '/' . ltrim($path, '/');
        return rtrim($normalized, '/') ?: '/';
    }
}
