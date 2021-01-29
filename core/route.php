<?php

class Route
{

    static function start()
    {
        $controller_name = 'main';
        $action_name = 'index';
        $model_name = 'task';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if ( !empty($routes[2]) )
        {
            $controller_name = $routes[2];
        }

        if ( !empty($routes[count($routes) - 1]) )
        {
            $action = explode('?', $routes[count($routes) - 1]);
            $action_name = $action[0];
        }

        $controller_name = $controller_name.'controller';
        $action_name = $action_name;

        $model_file = strtolower($model_name).'.php';
        $model_path = "../app/Models/".$model_file;
        if(file_exists($model_path))
        {
            include "../app/Models/".$model_file;
        }

        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "../app/Controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            include "../app/Controllers/".$controller_file;
        }
        else
        {
            Route::ErrorPage();
        }

        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            $controller->$action();
        }
        else
        {
            Route::ErrorPage();
        }

    }

    function ErrorPage()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}
