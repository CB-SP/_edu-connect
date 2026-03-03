<?php
    class AdminController extends Controller {
        private $admin, $school, $user;

        public function __construct() {
            $this->admin = new AdminModel;
            $this->school = new SchoolController;
            $this->user = new UserController;
        }

        //add admins
        public function add_admin($name, $photo, $email, $password) {
            if (empty($name) || empty($email) || empty($password)) {
                return false;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

            try {
                if (!($this->admin->add_admin($name, $photo, $email, $password))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADICIONAR_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //add standard admin
        public function add_standard_admin() {
            try {
                if (($this->admin_exists())) {
                    return false;
                }

                if (!($this->add_admin("Admin", "", "admin@gmail.com", "123456789"))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADICIONAR_ADMIN_PADRAO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //admins login
        public function login($email, $password) {
            if (empty($email) || empty($password)) {
                return false;
            }

            if (!($this->verify_password($password, $this->fetch_password_hash($email)))) {
                return false;
            }

            try {
                $admin = $this->admin->fetch_admin($email);

                if (empty($admin)) {
                    return false;
                }

                $_SESSION['id'] = $admin['id'];
                $_SESSION['nome'] = $admin['nome'];
            } catch (PDOException $e) {
                error_log("ERRO_LOGIN_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //==========schools managemant==========
        //create
        public function add_school($name, $address, $contact_1, $contact_2, $logo) {
            return $this->school->add_school($name, $address, $contact_1, $contact_2, $logo);
        }

        //update
        public function edit_school($name, $address, $contact_1, $contact_2, $logo, $id) {
            return $this->school->edit_school($name, $address, $contact_1, $contact_2, $logo, $id);
        }

        //read all
        public function fetch_schools() {
            return $this->school->fetch_schools();
        }

        //read one
        public function fetch_school($id) {
            return $this->school->fetch_school($id);
        }

        //delete
        public function delete_school($id) {
            return $this->school->delete_school($id);
        }

        //==========users managemant==========
        //create
        public function add_user($name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password) {
            return $this->user->add_user($name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password);
        }

        //update
        public function edit_user($name, $contact_1, $contact_2, $nif, $email, $foto, $id) {
            return $this->user->edit_user($name, $contact_1, $contact_2, $nif, $email, $foto, $id);
        }

        //read all
        public function fetch_users() {
            return $this->user->fetch_users();
        }

        //read one
        public function fetch_user($id) {
            return $this->user->fetch_user($id);
        }

        //delete
        public function delete_user($id) {
            return $this->user->delete_user($id);
        }

        //verify existing admins
        private function admin_exists() {
            try {
                return $this->admin->admin_exists();
            } catch (PDOException $e) {
                error_log("ERRO_VERIFICAR_EXISTENCIA_DE_ADMINS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }
        }

        //search admins password hash
        private function fetch_password_hash($email) {
            if (empty($email)) {
                return null;
            }

            try {
                return $this->admin->fetch_password_hash($email);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_HASH_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //verify admin password
        private function verify_password($password, $hash) {
            if (empty($password) || empty($hash)) {
                return false;
            }

            return password_verify($password, $hash);
        }
    }
?>