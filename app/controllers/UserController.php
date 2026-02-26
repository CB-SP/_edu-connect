<?php
    class UserController extends Controller {
        public function index() {
            $this->show_page("home");
        }

        public function teste() {
            $this->show_page("teste");
        }
    }
?>