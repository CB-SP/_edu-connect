<?php
    class PrincipalController extends UserController {
        private $director, $user;

        public function __construct() {
            $this->director = new PrincipalModel;
            $this->user = new UserController;
        }

        public function index() {
            $this->show_page("painel");
        }

        public function register() {
            $this->isLoged();
            $this->show_page("register");
        }

        public function messages() {
            $this->isLoged();
            $this->show_page("messages");
        }

        public function infoSchoolAccount() {
            $this->isLoged();
            $this->show_page("infoSchoolAccount");
        }

        //==========users managemant==========
        //create
        public function add_user() {
            $this->redirect($this->user->add_user() ? 'principal/index' : 'principal/index');
        }

        //update
        public function edit_user() {
            $this->redirect($this->user->edit_user() ? 'principal/index' : 'principal/index');
        }

        //read all
        public function fetch_users() {
            return $this->user->fetch_users();
        }

        //read one
        public function fetch_user($id) {
            header('Content-Type: application/json');

            echo json_encode($this->user->fetch_user($id));
            exit;
        }

        //delete
        public function delete_user($id) {
            $this->redirect($this->user->delete_user($id) ? 'principal/index' : 'principal/index');
        }

        //restore
        public function restore_user($id) {
            $this->redirect($this->user->restore_user($id) ? 'principal/index' : 'principal/index');
        }
    }
?>