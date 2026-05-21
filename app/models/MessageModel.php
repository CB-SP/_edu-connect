<?php
    class MessageModel extends Model {
        //get chat messages
        public function get_chat_messages(int $school, int $chat) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT m.id, m.conteudo, m.chat, m.created_at, u.nome AS user, u.foto AS user_foto, u.id AS user_id
                    FROM mensagens AS m
                    JOIN usuarios AS u ON u.id = m.usuario
                    JOIN chats AS c ON c.id = m.chat
                    JOIN turmas AS t ON t.id = c.turma
                    JOIN escolas AS e ON e.id = m.escola
                    WHERE e.id = ? AND c.id = ?
                    ORDER BY m.created_at ASC
                ");
                $this->stmt->execute([$school, $chat]);

                $messages = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $messages[] = $result;
                }

                return !empty($messages) ? $messages : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //send messages
        public function send_message(int $school, int $chat, string $content, int $user) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO mensagens (conteudo, chat, usuario, escola) VALUES (?, ?, ?, ?)");

                return $this->stmt->execute([$content, $chat, $user, $school]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get unread messages
        public function get_unread_messages(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT 
                        m.id,
                        m.conteudo,
                        m.created_at AS hora_envio,
                        
                        u.nome AS remetente,
                        t.nome AS turma,
                        t.id AS turma_id

                    FROM mensagens m

                    JOIN chats c ON c.id = m.chat
                    JOIN turmas t ON t.id = c.turma
                    JOIN usuarios u ON u.id = m.usuario

                    LEFT JOIN mensagens_lidas ml 
                        ON ml.mensagem = m.id 
                        AND ml.usuario = ?

                    WHERE 
                        ml.id IS NULL
                        
                        AND (
                            t.professor = ?
                            OR EXISTS (
                                SELECT 1
                                FROM alunos_turmas at
                                WHERE at.turma = t.id
                                AND at.aluno = ?
                            )
                        )

                        AND m.usuario != ?

                    ORDER BY m.created_at DESC;
                ");
                $this->stmt->execute([$id, $id, $id, $id]);

                $messages = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $messages[] = $result;
                }

                return !empty($messages) ? $messages : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //view messages
        public function view_message(int $message, int $user) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO mensagens_lidas (mensagem, usuario) VALUES (?, ?)");

                return $this->stmt->execute([$message, $user]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>