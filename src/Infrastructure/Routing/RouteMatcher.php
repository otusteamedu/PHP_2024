<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Routing;

class RouteMatcher
{
    public function matchRoute(string $url, string $method, Route $route): bool
    {
        return $this->matchMethod($method, $route->getMethod())
            && $this->matchUrl($url, $route->getPath(), $route->getRequirements());
    }

    private function matchMethod(string $targetMethod, string $routeMethod): bool
    {
        return $targetMethod === $routeMethod;
    }

    private function matchUrl(string $targetUrl, string $routeUrl, array $requirements): bool
    {
        // Экранируем символы, которые могут быть в шаблоне
        $template = preg_quote($routeUrl, '#');

        if ($requirements !== []) {
            foreach ($requirements as $placeholder => $pattern) {
                $template = str_replace(
                    preg_quote(
                        '{' . $placeholder . '}',
                        '#'
                    ),
                    '(' . $pattern . ')',
                    $template
                );
            }
        }

        $pattern = '#^' . $template . '$#';

        return preg_match($pattern, $targetUrl) === 1;
    }
}
