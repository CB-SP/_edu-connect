<?php
    class ChatController extends Controller {
        private $chat;

        public function __construct() {
            $this->chat = new ChatModel;
        }

        //create chat
        public function create_chat(int $class, int $school) {
            if (empty($class) || empty($school)) {
                return false;
            }

            try {
                if (!$this->chat->create_chat($class, $school)) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_CRIAR_CHAT: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //get chat
        public function get_chat(int $class, int $school) {
            if (empty($class) || empty($school)) {
                return null;
            }

            try {
                return $this->chat->get_chat($class, $school);
            } catch (PDOException $e) {
                error_log("ERRO_CRIAR_CHAT: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
    }
?>