<?php
    class AdminController extends Controller {
        private $admin, $school, $user, $id, $name, $photo, $email, $password;

        public function __construct() {
            $this->admin = new AdminModel;
            $this->school = new SchoolController;
            $this->user = new UserController;
        }

        public function index() {
            $this->isLoged();
            $this->isAdmin();
            $this->show_page("dashboard");
        }

        public function login() {
            $this->show_page("login");
        }

        public function register() {
            $this->isLoged();
            $this->isAdmin();
            $this->show_page("register");
        }
        public function settings() {
            $this->isLoged();
            $this->isAdmin();
            $this->show_page("settings");
        }
        public function infoAccount() {
            $this->isLoged();
            $this->isAdmin();
            $this->show_page("infoAccount");
        }
        public function security() {
            $this->isLoged();
            $this->isAdmin();
            $this->show_page("security");
        }

        //add admins
        public function add_admin($name, $photo, $email, $password) {
            if (empty($name) || empty($email) || empty($password)) {
                return false;
            }

            if(!Utils::password_length($password)) {
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
        public function login_admin() {
            $this->email = $_POST['email'] ?? null;
            $this->password = $_POST['password'] ?? null;

            if (empty($this->email) || empty($this->password)) {
                $this->redirect("admin/login");
            }

            if (!(Utils::verify_password($this->password, $this->fetch_password_hash($this->email)))) {
                $this->redirect("admin/login");
            }

            try {
                $admin = $this->admin->fetch_admin($this->email);

                if (empty($admin)) {
                    $this->redirect("admin/login");
                }

                $_SESSION['id'] = $admin['id'];
                $_SESSION['name'] = $admin['nome'];
            } catch (PDOException $e) {
                error_log("ERRO_LOGIN_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("admin/login");
            }

            $this->redirect("admin/index");
        }

        //find admin
        public function find_admin($id) {
            if (empty($id)) {
                return false;
            }

            try {
                return $this->admin->find_admin($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("admin/index");
            }
        }

        //edit admin
        public function edit_admin() {
            $this->name = $_POST['name'] ?? null;
            $this->email = $_POST['email'] ?? null;
            $this->id = $_POST['id'] ?? null;

            if (empty($this->name) || empty($this->email) || empty($this->id)) {
                return false;
            }

            try {
                if (!$this->admin->edit_admin($this->name, $this->email, $this->id)) {
                    $this->redirect("admin/index");
                }
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("admin/index");
            }

            $_SESSION['name'] = $this->name;
            $this->redirect("admin/index");
        }

        //change admin password
        public function change_password() {
            $this->password = $_POST['newPassword'];
            $currentPassword = $_POST['currentPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];
            $this->id = $_POST['id'];

            if (empty($this->password) || empty($currentPassword) || empty($confirmNewPassword)) {
                return false;
            }

            if (!Utils::confirmPassword($this->password, $confirmNewPassword)) {
                return false;
            }

            if (!Utils::password_length($this->password)) {
                return false;
            }

            if (!Utils::verify_password($currentPassword, $this->find_password_hash($this->id))) {
                return false;
            }

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);

            try {
                if (!$this->admin->change_password($this->password, $this->id)) {
                    $this->redirect("admin/index");
                }
            } catch (PDOException $e) {
                error_log("ERRO_ALTERAR_PASSWORD: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("admin/index");
            }

            $this->redirect("admin/index");
        }

        //fetch total entities
        public function total_entities() {
            try {
                return $this->admin->total_entities();
            } catch (PDOException $e) {
                error_log("ERRO_CONSULTAR_ENTIDADES: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //==========schools managemant==========
        //create
        public function add_school() {
            $this->redirect($this->school->add_school() ? 'admin/index' : 'admin/index');
        }

        //update
        public function edit_school() {
            $this->redirect($this->school->edit_school() ? 'admin/index' : 'admin/index');
        }

        //read all
        public function fetch_schools() {
            return $this->school->fetch_schools();
        }

        //read one
        public function fetch_school($id) {
            header('Content-Type: application/json');

            echo json_encode($this->school->fetch_school($id));
            exit;
        }

        //delete
        public function delete_school($id) {
            $this->redirect($this->school->delete_school($id) ? 'admin/index' : 'admin/index');
        }

        //restore
        public function restore_school($id) {
            $this->redirect($this->school->restore_school($id) ? 'admin/index' : 'admin/index');
        }

        //==========users managemant==========
        //create
        public function add_user() {
            $this->redirect($this->user->add_user() ? 'admin/index' : 'admin/index');
        }

        //update
        public function edit_user() {
            $this->redirect($this->user->edit_user() ? 'admin/index' : 'admin/index');
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
            $this->redirect($this->user->delete_user($id) ? 'admin/index' : 'admin/index');
        }

        //restore
        public function restore_user($id) {
            $this->redirect($this->user->restore_user($id) ? 'admin/index' : 'admin/index');
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

        //search admins password hash
        private function find_password_hash($id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->admin->find_password_hash($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_HASH_ADMIN: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //verify if the entity is an admin
        private function isAdmin() {
            if (isset($_SESSION['role'])) {
                $this->redirect('user/index');
            }
        }
    }
?>