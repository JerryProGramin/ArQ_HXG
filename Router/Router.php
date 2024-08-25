<?php

declare(strict_types=1);

namespace Router;

use Exception;

class Router
{
  private array $routes;

  public function __construct(string $routesFile)
  {
    $this->routes = require $routesFile;
  }

  public function dispatch(string $method, string $uri): void
  {
    // Normalize URI
    $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

    // Find the route
    $route = $this->findRoute($method, $uri);

    if ($route) {
      // Extract parameters
      $pattern = $route['pattern'];
      $params = $this->extractParams($uri, $pattern);

      // Call the callback function with parameters
      call_user_func_array($route['callback'], $params);
    } else {
      http_response_code(404);
      echo json_encode(['error' => 'Route not found']);
    }
  }

  private function findRoute(string $method, string $uri): ?array
  {
    foreach ($this->routes[$method] as $pattern => $callback) {
      if ($this->matchPattern($uri, $pattern)) {
        return ['pattern' => $pattern, 'callback' => $callback];
      }
    }
    return null;
  }

  private function matchPattern(string $uri, string $pattern): bool
  {
    // Convert route pattern to regex
    $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $pattern);
    $pattern = '#^' . $pattern . '$#';

    return preg_match($pattern, $uri) === 1;
  }

  private function extractParams(string $uri, string $pattern): array
  {
    // Convert pattern to regex for matching
    $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $pattern);
    preg_match('#^' . $pattern . '$#', $uri, $matches);

    // Extract parameters from matches
    return array_slice($matches, 1);
  }
}