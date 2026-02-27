<?php
    class UserController extends Controller {
        private $user;

        public function __construct() {
            $this->user = new UserModel;
        }

        public function index() {
            $this->show_page("login");
        }

        //add users
        public function add_user($name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password) {
            if (empty($name) || empty($contact_1) || empty($nif) || empty($password) || empty($role) || empty($school)) {
                return false;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

            try {
                if (!($this->user->add_user($name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //edit users
        public function edit_user($name, $contact_1, $contact_2, $nif, $email, $foto, $id) {
            if (empty($name) || empty($contact_1) || empty($nif) || empty($id)) {
                return false;
            }

            try {
                if (!($this->user->edit_user($name, $contact_1, $contact_2, $nif, $email, $foto, $id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_EDITAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //search for every users of a school
        public function fetch_users() {
            try {
                return $this->user->fetch_users();
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_USUARIOS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //delete users
        public function delete_user($id) {
            if (empty($id)) {
                return false;
            }

            try {
                if (!($this->user->delete_user($id, DATE))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_DELETAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //users logout
        protected function logout() {
            $this->isLoged();
            session_unset();
            session_destroy();
            $this->redirect("");
        }
    }
?>