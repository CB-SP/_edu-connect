<?php
    session_start();
    require_once "config/config.php";

    spl_autoload_register(function($class) {
        $paths = [
            "app/controllers",
            "app/models",
            "app/views",
            "core"
        ];

        foreach ($paths as $p) {
            $directory = "$p/$class.php";

            if (file_exists($directory)) {
                require_once $directory;
            }
        }
    });

    $route = new Router;
?>