<?php
    class UserController extends Controller {
        private $user;

        public function __construct() {
            $this->user = new UserModel;
        }

        public function index() {
            $this->isLoged();
            $this->show_page("home");
        }

        public function login() {
            $this->show_page("login");
        }

        public function register() {
            $this->isLoged();
            $this->show_page("register");
        }

        //users login
        public function login_user($nif, $password) {
            if (empty($nif) || empty($password)) {
                $this->redirect("user/login");
            }

            if (!(Utils::verify_password($password, $this->fetch_password_hash($nif)))) {
                $this->redirect("user/login");
            }

            try {
                $user_login = $this->user->fetch_user_data_login($nif);

                if (empty($user_login)) {
                    $this->redirect("user/login");
                }

                $_SESSION['id'] = $user_login['id'];
                $_SESSION['name'] = $user_login['nome'];
                $_SESSION['school'] = $user_login['escola'];
                $_SESSION['role'] = $user_login['role'];
                $_SESSION['photo'] = $user_login['foto'];
            } catch (PDOException $e) {
                error_log("ERRO_LOGIN_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("user/login");
            }

            $this->redirect("user/index");
        }

        //add users
        public function add_user($name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password) {
            if (empty($name) || empty($contact_1) || empty($nif) || empty($password) || empty($role) || empty($school)) {
                return false;
            }

            if (!Utils::password_length($password) || !Utils::nif_length($nif)) {
                return false;
            }

            if (!Utils::phone_number_length($contact_1) || (!empty($contact_2) && !Utils::phone_number_length($contact_2))) {
                return false;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

            try {
                if (!($this->user->add_user($name, $email, $contact_1, empty($contact_2) ? null : $contact_2, $nif, $school, $role, $photo, $password))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //edit users
        public function edit_user($name, $contact_1, $contact_2, $nif, $email, $photo, $id) {
            if (empty($name) || empty($contact_1) || empty($nif) || empty($id)) {
                return false;
            }

            if (!Utils::nif_length($nif)) {
                return false;
            }

            if (!Utils::phone_number_length($contact_1) || (!empty($contact_2) && !Utils::phone_number_length($contact_2))) {
                return false;
            }

            try {
                if (!($this->user->edit_user($name, $contact_1, empty($contact_2) ? null : $contact_2, $nif, $email, $photo, $id))) {
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

        //search for a unic user
        public function fetch_user($id) {
            try {
                header('Content-Type: application/json');
                echo json_encode($this->user->fetch_user($id));
                exit;
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                
                echo json_encode(['error' => 'Erro ao buscar usuário']);
                exit;
            }
        }

        //delete users
        public function delete_user($id) {
            if (empty($id)) {
                return false;
            }

            try {
                if (!($this->user->delete_user($id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_DELETAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //restore users
        public function restore_user($id) {
            if (empty($id)) {
                return false;
            }

            try {
                if (!($this->user->restore_user($id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_RESTAURAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //users logout
        public function logout() {
            $this->isLoged();
            session_unset();
            session_destroy();
            $this->redirect("");
        }

        //search users password hash
        private function fetch_password_hash($nif) {
            if (empty($nif)) {
                return null;
            }

            try {
                return $this->user->fetch_password_hash($nif);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_HASH_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //search users password hash
        private function fetch_password_hash($nif) {
            if (empty($nif)) {
                return null;
            }

            try {
                return $this->user->fetch_password_hash($nif);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_HASH_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
    }
?>