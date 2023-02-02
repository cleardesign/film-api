<?php

namespace FilmAPI;

use FilmAPI\Controller\BaseController;

/**
 * Router class used to map routes to controllers
 *
 * @package FilmApi
 */
class Router
{
    /**
     * @var $routes array Routes array.
     */
    private array $routes = [];

    /**
     * Keep Router instance
     *
     * @var $instance ?Router Instance of Router.
     */
    private static ?Router $instance = null;

    /**
     * Returns an instance of this class.
     *
     * @return ?Router Router instance.
     */
    public static function getInstance(): ?Router
    {
        if (null === self::$instance) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    /**
     * Get route
     *
     * @param string $route Route.
     * @param array $callback Callback class and method.
     */
    public function get(string $route, array $callback)
    {
        return $this->add($route, 'GET', $callback);
    }

    /**
     * Post route
     *
     * @param string $route Route.
     * @param array $callback Callback class and method.
     */
    public function post(string $route, array $callback)
    {
        return $this->add($route, 'POST', $callback);
    }

    /**
     * Patch route
     *
     * @param string $route Route.
     * @param array $callback Callback class and method.
     */
    public function patch(string $route, array $callback)
    {
        return $this->add($route, 'PATCH', $callback);
    }

    /**
     * Delete route
     *
     * @param string $route Route.
     * @param array $callback Callback class and method.
     */
    public function delete(string $route, array $callback)
    {
        return $this->add($route, 'DELETE', $callback);
    }

    /**
     * Add route in routes array.
     *
     * @param string $route Route.
     * @param string $method Method.
     * @param array $callback Callback class and method.
     */
    private function add(string $route, string $method, array $callback): void
    {
        $this->routes[] = array(
            'route'    => $route,
            'method'   => $method,
            'callback' => $callback,
        );
    }

    /**
     * Execute controller task based on route.
     *
     * @param string $basePath Base path for api route.
     */
    public function run(string $basePath): void
    {
        $basePath  = rtrim($basePath, '/') . '/';
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);

        $path = '';
        if (array_key_exists('path', $parsedUrl)) {
            $path = trim(str_replace($basePath, '', $parsedUrl['path']), '/');
        }
        $path = urldecode($path);

        $method = $_SERVER['REQUEST_METHOD'];

        $params = [];
        $callback = null;
        $routeFound = false;
        foreach ($this->routes as $route) {
            preg_match_all('/{[^}]*}/', $route['route'], $matches);

            if (empty($matches[0])) {
                // This route has no params, so we can just compare it
                if ($route['route'] !== $path) {
                    continue;
                }

                $routeFound = true;

                if ($method === $route['method']) {
                    $callback = $route['callback'];
                }

                continue;
            }

            // Route has params, try to match it and extract params from $path
            $regex = $route['route'];
            foreach ($matches[0] as $variable) {
                $varName = trim($variable, '{\}');
                $regex = str_replace($variable, '(?P<' . $varName . '>[^/]++)', $regex);
            }
            $regex = str_replace('/', '\\/', $regex);

            if (preg_match('/^' . $regex . '$/', $path, $matches)) {
                $params = array_filter($matches, function ($key) {
                    return is_string($key);
                }, ARRAY_FILTER_USE_KEY);

                $routeFound = true;

                if ($method === $route['method']) {
                    $callback = $route['callback'];
                }
            }
        }

        if (!is_null($callback)) {
            $controller = new $callback[0]();
            call_user_func_array([$controller, $callback[1]], $params);
        } else {
            $controller = new BaseController();
            if ($routeFound) {
                $controller->withJson(['msg' => 'Method Not Allowed'], 405);
            } else {
                $controller->withJson(['msg' => 'Route not found!'], 404);
            }
        }
    }
}
