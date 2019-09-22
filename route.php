<?php
class Route{
    
    // A base class for router. We will keep on adding routes in index
    // and their respective function handlers 

    private static $routes = Array();
    private static $pathNotFound = null;
    private static $methodNotAllowed = null;

    public static function add($exp, $func, $method = 'GET'){
        array_push(self::$routes, Array(
            'expression' => $exp,
            'function' => $func,
            'method' => $method
        ));
    }

    public static function pathNotFound($func){
        self::$pathNotFound = $func;
    }

    public static function methodNotAllowed($func){
        self::$methodNotAllowed = $func;
    }

    public static function run($basepath = '/'){
        //parse the url
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        
        if(isset($parsed_url['path'])){
            $path = $parsed_url['path'];
        }else{
            $path = '/';
        }

        $method = $_SERVER['REQUEST_METHOD'];

        $path_match_found = false;

        $route_match_found = false;

        foreach(self::$routes as $route){
            //check for matching function handler
            if($basepath != '' && $basepath != '/'){
                $route['expression'] = '('.$basepath.')'.$route['expression'];
            }

            $route['expression'] = '^'.$route['expression'].'$';
            
            if(preg_match('#'.$route['expression'].'#', $path, $matches)){
                $path_match_found = true;

                if(strtolower($method) == strtolower($route['method'])){
                    array_shift($matches);

                    if($basepath != '' && $basepath != '/'){
                        array_shift($matches);
                    }
                    
                    try
                    {
                        call_user_func_array($route['function'], $matches);
                        $route_match_found = TRUE;
                        break;
                    }
                    catch(Exception $e)
                    {
                        break;
                    }
                }
            }
        }

        if(!$route_match_found){
            if($path_match_found){
                header("HTTP/1.0 405 Method Not Allowed");
                if(self::$methodNotAllowed){
                    call_user_func_array(self::$methodNotAllowed, Array($path, $method));
                }
            }else{
                header("HTTP/1.0 404 Not Found");
                if(self::$pathNotFound){
                    call_user_func_array(self::$pathNotFound, Array($path));
                }
            }
        }
    }

    public static function redirect($url, $permanent = FALSE)
    {
        header('Location: '.$url, true, $permanent ? 301 : 302);
        exit();
    } 
}
?>