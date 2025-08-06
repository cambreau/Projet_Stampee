<?php
namespace App\Routes;
use App\Providers\View;

class Route {
    // Declaration d'une variable de type array qui contiendra les routes. Methode static donc pas besoin d'instancier
    private static $routes = [];

   public static function get($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

     public static function post($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

   public static function dispatch(){
        $url = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $urlSegments = explode('?', $url);
        $urlPath = rtrim($urlSegments[0],'/');

        //Debug
        // var_dump($url);
        // var_dump($method);
        // echo ('<br>');
        // echo ('<br>');
        // echo ('<br>');
        //Fin Debug

        foreach(self::$routes as $route){
            // Debug
            // var_dump(BASE.$route['url']);
            // var_dump($route['method']);
            // echo ('<br>');
            //Fin Debug
        
            if(BASE.$route['url'] == $urlPath && $route['method'] == $method){
                $controllerSegments = explode('@', $route['controller']);

                $controllerName = 'App\\Controllers\\'.$controllerSegments[0];
                $methodName = $controllerSegments[1];
                $controllerInstance = new $controllerName;

                if($method == 'GET'){
                    if(isset($urlSegments[1])){
                         parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($queryParams);
                    }else{
                        $controllerInstance->$methodName();
                    }
                }elseif($method == 'POST'){
                     if(isset($urlSegments[1])){
                         parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($_POST, $queryParams);
                    }else{
                         $controllerInstance->$methodName($_POST);
                    }
                }
                
             return;
            }
        }
        http_response_code(404);
        View::render('erreur404', ['message'=>'Page introuvable!']);
    }
}