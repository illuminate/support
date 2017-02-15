<?php

namespace Illuminate\Support\Facades;

/**
 * @method static \Illuminate\Routing\RouteRegistrar as(mixed $name)
 * @method static \Illuminate\Routing\RouteRegistrar domain(mixed $name)
 * @method static \Illuminate\Routing\RouteRegistrar middleware(mixed $name)
 * @method static \Illuminate\Routing\RouteRegistrar name(mixed $name)
 * @method static \Illuminate\Routing\RouteRegistrar namespace(mixed $name)
 * @method static \Illuminate\Routing\RouteRegistrar prefix(mixed $name)
 * @method static \Illuminate\Routing\Route get(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route post(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route put(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route delete(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route patch(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route options(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route any(string $uri, \Closure|array|string $action)
 * @method static \Illuminate\Routing\Route match(array|string $methods, string $uri, \Closure|array|string $action)
 * @method static void resources(array $resources)
 * @method static void resource(string $name, string $controller, array $options = [])
 * @method static void group(array $attributes, \Closure|string $callback)
 * @method static \Illuminate\Routing\Route substituteBindings(\Illuminate\Routing\Route $route)
 * @method static void substituteImplicitBindings(\Illuminate\Routing\Route $route)
 *
 * @see \Illuminate\Routing\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
