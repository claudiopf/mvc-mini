<?php

class Router
{
    private array $registeredRoutes = [];

    public function get(string $path, string $handler) {
        $this->registerRoute('GET', $path, $handler);
    }
    public function post(string $path, string $handler) {
        $this->registerRoute('POST', $path, $handler);
    }
    public function put(string $path, string $handler) {
        $this->registerRoute('PUT', $path, $handler);
    }
    public function patch(string $path, string $handler) {
        $this->registerRoute('PATCH', $path, $handler);
    }
    public function delete(string $path, string $handler) {
        $this->registerRoute('DELETE', $path, $handler);
    }

    private function registerRoute(string $httpMethod, string $routePath, string $handler)
    {
        $this->registeredRoutes[] = [
            'method'  => $httpMethod,
            'path'    => $routePath,
            'handler' => $handler
        ];
    }

    public function dispatch(string $currentUri, string $currentMethod)
    {
        $currentUri = parse_url($currentUri, PHP_URL_PATH);
        $currentUri = rtrim($currentUri, '/');
        if ($currentUri === '') $currentUri = '/';

        foreach ($this->registeredRoutes as $route) {
            $regexPath = '#^' . preg_replace('#\{(\w+)\}#', '([^/]+)', $route['path']) . '/?$#';

            if ($route['method'] === $currentMethod && preg_match($regexPath, $currentUri, $paramMatches)) {
                array_shift($paramMatches);

                [$controllerName, $methodName] = explode('@', $route['handler']);

                if (!class_exists($controllerName)) {
                    return $this->notFound("Controller {$controllerName} tidak ditemukan.");
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $methodName)) {
                    return $this->notFound("Method {$methodName} tidak ditemukan di controller {$controllerName}.");
                }

                $request = new Request();
                $response = new Response();

                call_user_func_array([$controller, $methodName], array_merge([$request, $response], $paramMatches));
                return;
            }
        }

        $this->notFound();
    }


    private function notFound(string $message = '404 Not Found')
    {
        http_response_code(404);
        echo $message;
    }
}