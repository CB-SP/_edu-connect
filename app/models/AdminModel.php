<?php
    class AdminModel extends Model {

        //add admins
        public function add_admin($name, $photo, $email, $password) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO admins (nome, foto, email, password) VALUES (?, ?, ?, ?)");
                
                return $this->stmt->execute([$name, $photo, $email, $password]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

         //verify existing admins
        public function admin_exists() {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id FROM admins WHERE deleted_at IS NULL");
                $this->stmt->execute();

                return $this->stmt->rowCount() > 0 ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search admins password hash
        public function fetch_password_hash($email) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT password FROM admins WHERE email = ? AND deleted_at IS NULL");
                $this->stmt->execute([$email]);

                $hash = $this->stmt->fetch(PDO::FETCH_ASSOC)['password'];

                return !empty($hash) ? $hash: null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //fetch admin
        public function fetch_admin($email) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id, nome FROM admins WHERE email = ? AND deleted_at IS NULL");
                $this->stmt->execute([$email]);

                $admin = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($admin) ? $admin : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //fetch total entities
        public function total_entities() {
            try {
                $this->stmt = $this->pdo->prepare("SELECT
                    (SELECT COUNT(id) FROM admins WHERE deleted_at IS NULL) AS admins,
                    (SELECT COUNT(id) FROM escolas WHERE deleted_at IS NULL) AS escolas,
                    (SELECT COUNT(id) FROM usuarios WHERE deleted_at IS NULL) AS usuarios
                ");
                $this->stmt->execute();

                $total_entities = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

                return !empty($total_entities) ? $total_entities : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>