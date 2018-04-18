<?php

//require './router-interface.php';

class AppRouter
{
    private $routes = [];

    public function resolve(Request $request)
    {

        $resolved = null;
        foreach ($this->routes as $route) {

            if ($route->getMethod() === $request->getMethod()) {

                $matches = [];
                if (preg_match($route->getUri(), $request->getUri(), $matches)) {
                    var_dump($matches);
                    $resolved = $route;
                    break;
                }

            }

        }
        return $resolved;
    }
    public function register(Route $route) : void
    {

        $this->routes[] = $route;
    }




}
