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
    }
?>