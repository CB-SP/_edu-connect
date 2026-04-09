<?php
    class ReactionModel extends Model {
        //react in posts
        public function react($user, $post, $type) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO reacoes (usuario, post, tipo) VALUES (?, ?, ?)");

                return $this->stmt->execute([$user, $post, $type]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //update reaction in posts
        public function update_reaction($user, $post, $type) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE reacoes SET tipo = ? WHERE usuario = ? AND post = ?");

                return $this->stmt->execute([$type, $user, $post]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //update react in posts
        public function delete_reaction($user, $post) {
            try {
                $this->stmt = $this->pdo->prepare("DELETE FROM reacoes WHERE usuario = ? AND post = ?");

                return $this->stmt->execute([$user, $post]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //verify if the post is allready reacted
        public function isReacted($user, $post) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT tipo FROM reacoes WHERE usuario = ? AND post = ?");
                $this->stmt->execute([$user, $post]);

                $type = $this->stmt->fetch(PDO::FETCH_ASSOC)['tipo'];

                return !empty($type) ? $type : null;
            } catch (PDOException $e) {
                throw $e;
            }          
        }
    }
?>