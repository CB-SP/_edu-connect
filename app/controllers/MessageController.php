<?php
    class MessageController extends Controller {
        private $message, $school, $chat, $content, $user;

        public function __construct() {
            $this->message = new MessageModel;
        }

        //send messages
        public function send_message(int $class) {
            $this->school = $_POST['school'] ?? null;
            $this->chat = $_POST['chat'] ?? null;
            $this->content = $_POST['content'] ?? null;
            $this->user = $_POST['user'] ?? null;

            if (empty($this->school) || empty($this->chat) || empty($this->content) || empty($this->user)) {
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

            $this->redirect("teacher/class/$class");
        }

        //get chat messages
        public function get_chat_messages(int $school, int $chat) {
            if (empty($school) || empty($chat)) {
                return null;
            }

            try {
                return $this->message->get_chat_messages($school, $chat);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_MENSAGENS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
    }
?>