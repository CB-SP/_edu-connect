<?php
    class ChatModel extends Model {
        //create chat
        public function create_chat(int $class, int $school) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO chats (turma, escola) VALUES (?, ?)");

                return $this->stmt->execute([$class, $school]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get chat
        public function get_chat(int $class, int $school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id FROM chats WHERE turma = ? AND escola = ?");
                $this->stmt->execute([$class, $school]);

                $id = $this->stmt->fetch(PDO::FETCH_ASSOC)['id'];

                return !empty($id) ? $id : false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>