<?php
    class UserController extends Controller {
        private $user, $coordinator, $post, $reaction, $comment, $id, $name, $email, $contact_1, $contact_2, $nif, $school, $role, $photo, $password;

        public function __construct() {
            $this->user = new UserModel;
            $this->coordinator = new CoordinatorController;
            $this->post = new PostController;
            $this->reaction = new ReactionController;
            $this->comment = new CommentController;
        }

        public function index() {
            $this->isLoged();
            $this->is_user();
            $this->show_page("feed");
        }

        public function login() {
            $this->show_page("login");
        }

        public function settings() {
            $this->isLoged();
            $this->is_user();
            $this->show_page("settings");
        }

        public function infoAccount() {
            $this->isLoged();
            $this->is_user();
            $this->show_page("infoAccount");
        }

        public function security() {
            $this->isLoged();
            $this->is_user();
            $this->show_page("security");
        }
        public function class() {
            $this->isLoged();
            $this->is_user();
            $this->show_page("class");
        }
        public function messages() {
            $this->isLoged();
            $this->is_user();
            $this->show_page("messages");
        }

        
        //users login
        public function login_user() {
            $this->nif = $_POST['nif'] ?? null;
            $this->password = $_POST['password'] ?? null;

            if (empty($this->nif) || empty($this->password)) {
                $this->redirect("user/login");
            }

            if (!(Utils::verify_password($this->password, $this->fetch_password_hash($this->nif)))) {
                $this->redirect("user/login");
            }

            try {
                $user_login = $this->user->fetch_user_data_login($this->nif);

                if (empty($user_login)) {
                    $this->redirect("user/login");
                }

                $_SESSION['id'] = $user_login['id'];
                $_SESSION['name'] = $user_login['nome'];
                $_SESSION['school'] = $user_login['escola'];
                $_SESSION['school_id'] = $user_login['escola_id'];
                $_SESSION['role'] = $user_login['role'];
                $_SESSION['photo'] = $user_login['foto'];
            } catch (PDOException $e) {
                error_log("ERRO_LOGIN_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("user/login");
            }

            $this->redirect("user/index");
        }

        //add users
        public function add_user() {
            $this->name = $_POST['name'] ?? null;
            $this->email = $_POST['email'] ?? null;
            $this->contact_1 = $_POST['contact_1'] ?? null;
            $this->contact_2 = $_POST['contact_2'] ?? null;
            $this->nif = $_POST['nif'] ?? null;
            $this->school = $_POST['school'] ?? null;
            $isCoordinator = $_POST['role'];
            $this->role = $isCoordinator === 'coordenador' ? 'professor' : $isCoordinator ?? null;
            $this->password = $_POST['password'] ?? null;

            if (empty($this->name) || empty($this->contact_1) || empty($this->nif) || empty($this->password) || empty($this->role) || empty($this->school)) {
                return false;
            }

            if (!Utils::password_length($this->password) || !Utils::nif_length($this->nif)) {
                return false;
            }

            if (!Utils::phone_number_length($this->contact_1) || (!empty($this->contact_2) && !Utils::phone_number_length($this->contact_2))) {
                return false;
            }

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->photo = Utils::uploadAvatar() ?? null;

            try {
                if (!($this->user->add_user($this->name, $this->email, $this->contact_1, empty($this->contact_2) ? null : $this->contact_2, $this->nif, $this->school, $this->role, $this->photo, $this->password))) {
                    return false;
                }

                if ($isCoordinator === 'coordenador') {
                    if (!$this->coordinator->add_coordinator($this->get_user_id($this->nif))) {
                        return false;
                    }

                    return true;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //edit users
        public function edit_user() {
            $this->id = $_POST['id'] ?? null;
            $this->name = $_POST['name'] ?? null;
            $this->contact_1 = $_POST['contact_1'] ?? null;
            $this->contact_2 = $_POST['contact_2'] ?? null;
            $this->nif = $_POST['nif'] ?? null;
            $this->email = $_POST['email'] ?? null;

            $currentPhoto = $_POST['current_photo'] ?? null;
            $newPhoto = Utils::uploadAvatar();

            if (empty($this->name) || empty($this->contact_1) || empty($this->nif) || empty($this->id)) {
                return false;
            }

            if (!Utils::nif_length($this->nif)) {
                return false;
            }

            if (!Utils::phone_number_length($this->contact_1) || (!empty($this->contact_2) && !Utils::phone_number_length($this->contact_2))) {
                return false;
            }

            if ($newPhoto !== null) {
                $this->photo = $newPhoto;

                if (!empty($currentPhoto)) {
                    $oldPath = __DIR__ . "/../../public/" . $currentPhoto;

                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

            } else {
                $this->photo = $currentPhoto;
            }

            try {
                if (!($this->user->edit_user($this->name, $this->contact_1, empty($this->contact_2) ? null : $this->contact_2, $this->nif, $this->email, $this->photo, $this->id))) {
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

        //find user
        public function find_user($id) {
            if (empty($id)) {
                return false;
            }

            try {
                return $this->user->find_user($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("user/index");
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

        //change user password
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
                if (!$this->user->change_password($this->password, $this->id)) {
                    $this->redirect("user/index");
                }
            } catch (PDOException $e) {
                error_log("ERRO_ALTERAR_PASSWORD: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("user/index");
            }

            $this->redirect("user/index");
        }

        //==========posts managemant==========
        //make a post
        public function publish() {
            $this->redirect($this->post->publish() ? 'user/index' : 'user/index');
        }

        //get all posts of a school
        public function get($school) {
            return $this->post->get_posts($school);
        }

        //get publications count
        public function count_publications($school) {
            return $this->post->count_publications($school);
        }

        //react in posts
        public function react() {
            $this->redirect($this->reaction->react() ? 'user/index' : 'user/index');
        }

        //get user reactions
        public function get_reactions($user, $post) {
            return $this->reaction->get_reactions($user, $post);
        }

        //comment in posts
        public function comment() {
            $this->redirect($this->comment->comment() ? 'user/index' : 'user/index');
        }

        //get post comments
        public function get_post_comments($post) {
            return $this->comment->get_post_comments($post);
        }

        //get interactions quantity
        public function get_interactions($post) {
            return $this->post->get_interactions($post);
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

        //get user id
        private function get_user_id($nif) {
            if (empty($nif)) {
                return false;
            }

            try {
                $id = $this->user->get_user_id($nif);

                return !empty($id) ? $id : null;
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
            }
        }

        //search users password hash
        private function find_password_hash($id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->user->find_password_hash($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_HASH_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //verify if its a normal user
        private function is_user() {
            if (!isset($_SESSION['role'])) {
                $this->redirect('user/login');
            }
        }
    }

?>