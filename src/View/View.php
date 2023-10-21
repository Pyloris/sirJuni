<?php
namespace sirJuni\Framework\View;


class VIEW {
    public static $path;
    public static $request;

    public static function set_path($path) {
        self::$path = rtrim($path, '\\');
    }

    // set the request context from Application
    public static function set_context($request) {
        self::$request = $request;
    }

    public static function init($page, $data=NULL) {

        // generate the route placeholder context
        $context = $data ?? [];
        
        foreach(self::$request->getRouteKeys() as $key) {
            $context[$key] = self::$request->getRouteValue($key);
        }

        // unpack get variables too
        foreach(self::$request->queryKeys() as $key) {
            $context[$key] = self::$request->queryData($key);
        }

        // provides all the route variables and data passed
        // as variables.
        if ($context)
            extract($context);

        include self::$path . "\\$page";
    }
}

?>