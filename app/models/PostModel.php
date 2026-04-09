<?php
    class PostModel extends Model {
        //make a post
        public function publish($content, $type, $user, $school) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO posts (conteudo, tipo, usuario, escola) VALUES (?, ?, ?, ?)");
                
                return $this->stmt->execute([$content, $type, $user, $school]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get all posts of a school
        public function get_posts($school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT p.id, p.conteudo, p.tipo, p.created_at, u.nome AS user, u.foto
                    FROM posts AS p
                    JOIN usuarios AS u ON u.id = p.usuario
                    JOIN escolas AS e ON e.id = p.escola
                    WHERE p.escola = ?
                    ORDER BY p.created_at DESC
                ");
                $this->stmt->execute([$school]);

                $posts = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $posts[] = $result;
                }

                return !empty($posts) ? $posts : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get publications count
        public function count_publications($school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT
                    (SELECT COUNT(id) FROM POSTS WHERE tipo = 'post' AND escola = ?) AS posts,
                    (SELECT COUNT(id) FROM POSTS WHERE tipo = 'aviso' AND escola = ?) AS notices
                ");
                $this->stmt->execute([$school, $school]);

                $pubsCount = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($pubsCount) ? $pubsCount : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>