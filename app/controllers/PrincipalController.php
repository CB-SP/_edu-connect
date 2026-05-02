<?php
    class PrincipalController extends UserController {
        private $principal, $user, $school;

        public function __construct() {
            $this->principal = new PrincipalModel;
            $this->user = new UserController;
            $this->school = new SchoolController;
        }

        public function index() {
            $this->isLoged();
            Utils::private_route('director');
            $this->show_page("painel");
        }

        public function messages() {
            $this->isLoged();
            Utils::private_route('director');
            $this->show_page("messages");
        }

        public function infoSchoolAccount() {
            $this->isLoged();
            Utils::private_route('director');
            $this->show_page("infoSchoolAccount");
        }

        //fetch total entities
        public function total_entities($school) {
            try {
                return $this->principal->total_entities($school);
            } catch (PDOException $e) {
                error_log("ERRO_CONSULTAR_ENTIDADES: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //==========schools managemant==========
        //update
        public function edit_school() {
            $this->redirect($this->school->edit_school() ? 'principal/index' : 'principal/index');
        }

        //read one
        public function find_school($id) {
            return $this->school->find_school($id);
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
        public function fetch_school_users(int $school) {
            return $this->user->fetch_users($school);
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