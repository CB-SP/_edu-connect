<?php
    class CommentModel extends Model {
        //make a comment in a post
        public function comment($content, $user, $post, $school) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO comentarios (conteudo, usuario, post, escola) VALUES (?, ?, ?, ?)");

                return $this->stmt->execute([$content, $user, $post, $school]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get post comments
        public function get_post_comments($post) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.foto, u.nome AS usuario, c.conteudo, c.created_at
                    FROM comentarios AS c
                    JOIN usuarios AS u ON u.id = c.usuario
                    JOIN posts AS p ON p.id = c.post
                    JOIN escolas AS e ON e.id = c.escola
                    WHERE c.post = ?
                ");
                $this->stmt->execute([$post]);

                $comments = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $comments[] = $result;
                }

                return !empty($comments) ? $comments : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>