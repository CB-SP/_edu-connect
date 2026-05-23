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

        //fetch admins
        public function fetch_admins(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id, nome, foto, email, deleted_at FROM admins WHERE id != ?");
                $this->stmt->execute([$id]);

                $admins = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $admins[] = $result;
                }

                return !empty($admins) ? $admins : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search admins
        public function search_admins(int $id, string $term) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id, nome, foto, email, deleted_at
                    FROM admins
                    WHERE id != ? AND nome LIKE ?
                ");
                $search = "%$term%";
                $this->stmt->execute([$id, $search]);

                $admins = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $admins[] = $result;
                }

                return !empty($admins) ? $admins : null;
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

        //search admins password hash
        public function find_password_hash($id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT password FROM admins WHERE id = ? AND deleted_at IS NULL");
                $this->stmt->execute([$id]);

                $hash = $this->stmt->fetch(PDO::FETCH_ASSOC)['password'];

                return !empty($hash) ? $hash: null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //fetch admin
        public function fetch_admin($email) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id, nome, foto FROM admins WHERE email = ? AND deleted_at IS NULL");
                $this->stmt->execute([$email]);

                $admin = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($admin) ? $admin : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //find admin
        public function find_admin($id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT foto, email, created_at FROM admins WHERE id = ? AND deleted_at IS NULL");
                $this->stmt->execute([$id]);

                $admin = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($admin) ? $admin : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //edit admin
        public function edit_admin($name, $email, $avatar, $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE admins SET nome = ?, email = ?, foto = ? WHERE id = ? AND deleted_at IS NULL");

                return $this->stmt->execute([$name, $email, $avatar, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //change admin password
        public function change_password($password, $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE admins SET password = ? WHERE id = ? AND deleted_at IS NULL");

                return $this->stmt->execute([$password, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //fetch total entities
        public function total_entities() {
            try {
                $this->stmt = $this->pdo->prepare("SELECT
                    (SELECT COUNT(id) FROM admins WHERE deleted_at IS NULL) AS admins,
                    (SELECT COUNT(id) FROM escolas WHERE deleted_at IS NULL) AS schools,
                    (SELECT COUNT(id) FROM usuarios WHERE role = 'director' AND deleted_at IS NULL) AS directors,
                    (SELECT COUNT(id) FROM usuarios WHERE role = 'professor' AND deleted_at IS NULL) AS teachers,
                    (SELECT COUNT(id) FROM usuarios WHERE role = 'aluno' AND deleted_at IS NULL) AS students,
                    (SELECT COUNT(u.id) FROM usuarios AS u JOIN coordenadores AS c ON c.id = u.id WHERE u.role = 'professor' AND u.deleted_at IS NULL) AS coordinators
                ");
                $this->stmt->execute();

                $total_entities = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

                return !empty($total_entities) ? $total_entities : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //restore admins
        public function restore_admin(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE admins SET deleted_at = null WHERE id = ?");

                return $this->stmt->execute([$id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //delete admins
        public function delete_admin(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE admins SET deleted_at = ? WHERE id = ?");

                return $this->stmt->execute([DATE, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>