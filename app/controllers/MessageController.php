<?php
    class MessageController extends Controller {
        private $message, $school, $chat, $content, $user;

        public function __construct() {
            $this->message = new MessageModel;
        }

        //send messages
        public function send_message(int $class, string $role) {
            $this->school = $_POST['school'] ?? null;
            $this->chat = $_POST['chat'] ?? null;
            $this->content = $_POST['content'] ?? null;
            $this->user = $_POST['user'] ?? null;

            if (empty($this->school) || empty($this->chat) || empty($this->content) || empty($this->user) || empty($role)) {
                $this->redirect("teacher/class/$class/error");
            }

            try {
                if (!$this->message->send_message($this->school, $this->chat, $this->content, $this->user)) {
                    $this->redirect("teacher/class/$class/error");
                }
            } catch (PDOException $e) {
                error_log("ERRO_ENVIAR_MENSAGEM: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("teacher/class/$class/error");
            }

            $this->redirect($role === 'professor' ? "teacher/class/$class" : "student/class/$class");
        }

        //get chat messages
        public function get_chat_messages(int $school, int $chat) {
            if (empty($school) || empty($chat)) {
                return null;
            }

            try {
                header('Content-Type: application/json');
                
                echo json_encode($this->message->get_chat_messages($school, $chat));
                exit;
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_MENSAGENS: ". $e->getMessage(). "\n". $e->getTraceAsString());

                echo json_encode(['error' => 'Erro ao buscar usuário']);
                exit;
            }
        }

        //get unread messages
        public function get_unread_messages(int $id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->message->get_unread_messages($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_MENSAGENS_NAO_LIDAS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //view messages
        public function view_message(int $message, int $user, int $class, string $role) {
            if (empty($message) || (empty($user)) || empty($role) || empty($class)) {
                $this->redirect("user/index/error");
            }

            try {
                if (!$this->message->view_message($message, $user)) {
                    $this->redirect("user/index/error");
                }
            } catch (PDOException $e) {
                error_log("ERRO_VISUALIZAR_MENSAGENS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("user/index/error");
            }

            $this->redirect($role === "professor" ? "teacher/class/$class" : "student/class/$class");
        }
    }
?>