<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('routeController'))
{
    /*
    | --------------------------------------------------------------------------------------------------------------
    | Alternate route for Laravel Route::controller
    | --------------------------------------------------------------------------------------------------------------
    | $prefix       = path of route
    | $controller   = controller name
    | $namespace    = namespace of controller (optional)
    |
    */
    // function routeController($prefix, $controller, $namespace = null)
    // {
    //     $prefix = trim($prefix, '/').'/';

    //     $namespace = ($namespace) ?: 'App\Http\Controllers';

    //     try {
    //         Route::post($prefix, ['uses' => $controller.'@postIndex', 'as' => $controller.'PostIndex']);
    //         Route::get($prefix, ['uses' => $controller.'@getIndex', 'as' => $controller.'GetIndex']);

    //         $controller_class = new \ReflectionClass($namespace.'\\'.$controller);
    //         $controller_methods = $controller_class->getMethods(\ReflectionMethod::IS_PUBLIC);
    //         $wildcards = '/{one?}/{two?}/{three?}/{four?}/{five?}';
    //         foreach ($controller_methods as $method) {
    //             if ($method->class != 'Illuminate\Routing\Controller' && $method->name != 'getIndex') {                    
    //                 if (substr($method->name, 0, 3) == 'get') {
    //                     $method_name = substr($method->name, 3);
    //                     $slug = array_filter(preg_split('/(?=[A-Z])/', $method_name));
    //                     $slug = strtolower(implode('-', $slug));
    //                     $slug = ($slug == 'index') ? '' : $slug;
    //                     Route::get($prefix.$slug.$wildcards, ['uses' => $controller.'@'.$method->name, 'as' => $controller.'Get'.$method_name]);
    //                 } elseif (substr($method->name, 0, 4) == 'post') {
    //                     $method_name = substr($method->name, 4);
    //                     $slug = array_filter(preg_split('/(?=[A-Z])/', $method_name));
    //                     $controller = $method->class;
    //                     Route::post($prefix.strtolower(implode('-', $slug)).$wildcards, [
    //                         'uses' => $controller.'@'.$method->name,
    //                         'as' => $controller.'Post'.$method_name,
    //                     ]);
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {

    //     }
    // }

    function routeController($prefix, $controller, $namespace = null)
    {
        $prefix = trim($prefix, '/') . '/';
        $namespace = ($namespace) ?: 'App\Http\Controllers';
    
        try {
            Route::prefix($prefix)->group(function () use ($controller, $namespace) {
                $controller_class = $namespace . '\\' . $controller;
    
                $controller_methods = (new \ReflectionClass($controller_class))->getMethods(\ReflectionMethod::IS_PUBLIC);
    
                foreach ($controller_methods as $method) {
                    if ($method->class != 'Illuminate\Routing\Controller' && $method->name != 'getIndex') {
                        if (!in_array($method->name, ['__construct', 'action', 'middleware', 'getMiddleware', 'callAction', '__call', 'authorize', 'authorizeForUser'])) {
                            $method_name = $method->name;
                            if (substr($method->name, 0, 3) == 'get') {
                                $method_name1 = substr($method->name, 3);
                            }
                            if (substr($method->name, 0, 4) == 'post') {
                                $method_name1 = substr($method->name, 4);
                            }
                            $slug = array_filter(preg_split('/(?=[A-Z])/', $method_name1));
                            $slug = strtolower(implode('-', $slug));
                            $slug = ($slug == 'index') ? '' : $slug;
        
                            // Dynamically add route parameters with valid regular expressions
                            $parameters = $method->getParameters();
                            $wildcards = "";
                            foreach($parameters as $param) {
                                $parameterName = $param->getName();
                                if (!empty($parameterName) && !in_array($parameterName, ['table'])) {
                                    $wildcards .= "/{".$parameterName."?}";  
                                }
                            }

                            if (substr($method->name, 0, 3) == 'get') {
                                $route = Route::get($slug.$wildcards, [$controller_class, $method_name]);
                                $route->name($controller . 'Get' . $method_name);
                            }

                            if (substr($method->name, 0, 4) == 'post') {
                                $route = Route::post($slug.$wildcards, [$controller_class, $method_name]);
                                $route->name($controller . 'Post' . $method_name);
                            }
        
                            if (count($parameters) > 0) {
                                foreach ($parameters as $parameter) {
                                    $parameterName = $parameter->getName();
                                    // Check if the parameter should have a constraint
                                    if (!empty($parameterName) && !in_array($parameterName, ['table'])) {
                                        // dd($parameterName);
                                        $route->where($parameterName, '.*');
                                    }
                                }
                            }
                        }
                    }
                }
    
                // Add routes for POST and GET methods here if needed
                Route::post('/', [$controller_class, 'postIndex'])->name($controller . 'PostIndex');
                Route::get('/', [$controller_class, 'getIndex'])->name($controller . 'GetIndex');
            });
        } catch (\Exception $e) {
            // Handle any exceptions here
        }
    }
}

if (!function_exists('adminRoute'))
{
    /**
     * @param string $url
     *
     * link admin route
     */
    function adminRoute($url = "")
    {
        return url("/admin/$url");
    }
}

if (!function_exists('adminMainRoute'))
{
    /**
     * @param null $path
     *
     * link admin main route
     */
    function adminMainRoute($path = null)
    {

        $controllername = str_replace(["App\Http\Controllers\\"], "", strtok(Route::currentRouteAction(), '@'));
        $route_url = route($controllername.'GetIndex');

        if ($path) {
            if (substr($path, 0, 1) == '?') {
                return trim($route_url, '/').$path;
            } else {
                return $route_url.'/'.$path;
            }
        } else {
            return trim($route_url, '/');
        }
    }
}
