<?php
    class UserController extends Controller {
        public function index() {
            $this->show_page("admin");
        }

        public function teste() {
            $this->show_page("teste");
        }
    }
?>