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
    }
?>