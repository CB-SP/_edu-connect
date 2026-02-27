<?php
    class Controller {
        protected function show_page($file) {
            $parent_class = get_parent_class($this);
            $class = get_class($this);

            if ($parent_class === 'UserController') {
                $parent_folder = strtolower(str_replace("Controller", "", $parent_class));
                $child_folder = strtolower(str_replace("Controller", "", $class));

                require_once "app/views/$parent_folder/$child_folder/$file.phtml";
            } else {
                $folder = strtolower(str_replace("Controller", "", $class));

                require_once "app/views/$folder/$file.phtml";
            }

        }

        protected function redirect($path) {
            header('Location: '. URL. $path);
            exit;
        }

        protected function isLoged() {
            if (!isset($_SESSION['id'], $_SESSION['name'])) {
                $this->redirect("");
            }
        }
    }
?>