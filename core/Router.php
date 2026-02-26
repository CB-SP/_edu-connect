<?php
    class Router {
        public function __construct() {
            $this->index();
        }

        private function index() {
            if (empty($_GET['url'])) {
                $home = new UserController;
                $home->index();
            } else {
                $url = explode("/", $_GET['url']);
                $parameters = array_slice($url, 2);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $parameters = array_merge($parameters, $_POST);
                } else {
                    $array_get = $_GET;
                    unset($array_get['url']);
                    $parameters = array_merge($parameters, $array_get);
                }

                $controller = !isset($url[0]) || empty($url[0]) ? 'UserController' : ucfirst($url[0]). "Controller";
                $action = !isset($url[1]) || empty($url[1]) ? 'index' : $url[1];

                if (class_exists($controller)) {
                    $class = new $controller;

                    if (method_exists($class, $action)) {
                        call_user_func_array([$class, $action], $parameters);
                    } else {
                        require_once "app/views/errors/404.phtml";
                    }
                } else {
                    require_once "app/views/errors/404.phtml";
                }
            }
        }
    }
?>