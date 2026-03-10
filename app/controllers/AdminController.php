<?php
    class AdminController extends Controller {
        private $admin, $school, $user;

        public function __construct() {
            $this->admin = new AdminModel;
            $this->school = new SchoolController;
            $this->user = new UserController;
        }

        public function dashboard() {
            $this->isLoged();
            $this->show_page("dashboard");
        }

        public function login() {
            $this->show_page("login");
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
        public function login_admin($email, $password) {
            if (empty($email) || empty($password)) {
                $this->redirect("admin/login");
            }

            if (!(Utils::verify_password($password, $this->fetch_password_hash($email)))) {
                $this->redirect("admin/login");
            }

            try {
                $admin = $this->admin->fetch_admin($email);

                if (empty($admin)) {
                    $this->redirect("admin/login");
                }

                $_SESSION['id'] = $admin['id'];
                $_SESSION['name'] = $admin['nome'];
            } catch (PDOException $e) {
                error_log("ERRO_LOGIN_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("admin/login");
            }

            $this->redirect("admin/dashboard");
        }

        //==========schools managemant==========
        //create
        public function add_school($name, $address, $contact_1, $contact_2, $logo) {
            $this->redirect($this->school->add_school($name, $address, $contact_1, $contact_2, $logo) ? 'admin/dashboard' : 'admin/dashboard');
        }

        //update
        public function edit_school($name, $address, $contact_1, $contact_2, $logo, $id) {
            $this->redirect($this->school->edit_school($name, $address, $contact_1, $contact_2, $logo, $id) ? 'admin/dashboard' : 'admin/dashboard');
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
            $this->redirect($this->school->delete_school($id) ? 'admin/dashboard' : 'admin/dashboard');
        }

        //==========users managemant==========
        //create
        public function add_user($name, $contact_1, $contact_2, $nif, $email, $password, $photo, $school, $role) {
            $this->redirect($this->user->add_user($name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password) ? 'admin/dashboard' : 'admin/dashboard');
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
            $this->redirect($this->user->delete_user($id) ? 'admin/dashboard' : 'admin/dashboard');
        }

        //admins logout
        public function logout() {
            $this->isLoged();
            session_unset();
            session_destroy();
            $this->redirect("admin/login");
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
    }
?>