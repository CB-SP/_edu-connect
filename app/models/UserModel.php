<?php
    class UserModel extends Model {
        //add users
        public function add_user($name, $email, $first_contact, $second_contact, $nif, $school, $role, $photo, $password) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO usuarios (nome, contacto_1, contacto_2, nif, email, foto, password, role, escola) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                return $this->stmt->execute([$name, $first_contact, $second_contact, $nif, $email, $photo, $password, $role, $school]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //edit users
        public function edit_user($name, $contact_1, $contact_2, $nif, $email, $photo, $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE usuarios SET nome = ?, contacto_1 = ?, contacto_2 = ?, nif = ?, email = ?, foto = ? WHERE id = ?");

                return $this->stmt->execute([$name, $contact_1, $contact_2, $nif, $email, $photo, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search for every users of a school
        public function fetch_school_users(int $school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, u.deleted_at, e.nome AS escola,
                    e.id AS escola_id, e.deleted_at AS estado_escola, c.role AS coordinator_role
                    FROM usuarios AS u
                    LEFT JOIN coordenadores AS c ON c.id = u.id
                    JOIN escolas AS e ON u.escola = e.id
                    WHERE e.id = ? AND u.role != 'director'
                    ORDER BY u.nome
                ");
                $this->stmt->execute([$school]);

                $users = [];
                
                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $users[] = $result;
                }

                return !empty($users) ? $users : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search for every users
        public function fetch_users() {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, u.deleted_at, e.nome AS escola,
                    e.id AS escola_id, e.deleted_at AS estado_escola, c.role AS coordinator_role
                    FROM usuarios AS u
                    LEFT JOIN coordenadores AS c ON c.id = u.id
                    JOIN escolas AS e ON u.escola = e.id
                    ORDER BY u.nome
                ");
                $this->stmt->execute();

                $users = [];
                
                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $users[] = $result;
                }

                return !empty($users) ? $users : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search for a unic user
        public function fetch_user(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, e.id AS escola FROM usuarios AS u JOIN escolas AS e ON u.escola = e.id WHERE u.id = ? AND u.deleted_at IS NULL AND e.deleted_at IS NULL");
                $this->stmt->execute([$id]);

                $user = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($user) ? $user : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //find user
        public function find_user(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT email, contacto_1, contacto_2, nif, foto, created_at FROM usuarios WHERE id = ? AND deleted_at IS NULL");
                $this->stmt->execute([$id]);

                $user = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($user) ? $user : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //delete users
        public function delete_user(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE usuarios SET deleted_at = ? WHERE id = ?");

                return $this->stmt->execute([DATE, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //restore users
        public function restore_user(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE usuarios SET deleted_at = null WHERE id = ?");

                return $this->stmt->execute([$id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search users password hash
        public function find_password_hash(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT password FROM usuarios WHERE id = ? AND deleted_at IS NULL");
                $this->stmt->execute([$id]);

                $hash = $this->stmt->fetch(PDO::FETCH_ASSOC)['password'];

                return !empty($hash) ? $hash: null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search users password hash
        public function fetch_password_hash(string $nif) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.password FROM usuarios AS u JOIN escolas AS e ON e.id = u.escola WHERE nif = ? AND u.deleted_at IS NULL AND e.deleted_at IS NULL");
                $this->stmt->execute([$nif]);

                $user = $this->stmt->fetch(PDO::FETCH_ASSOC)['password'];

                return !empty($user) ? $user : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //change user password
        public function change_password(string $password, int $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ? AND deleted_at IS NULL");

                return $this->stmt->execute([$password, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //fetch user id
        public function fetch_user_data_login(string $nif) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.role, u.foto, e.nome AS escola, e.id AS escola_id, e.logo, c.role AS coordinator_role
                    FROM usuarios AS u
                    JOIN escolas AS e ON e.id = u.escola
                    LEFT JOIN coordenadores AS c ON c.id = u.id
                    WHERE u.nif = ? AND u.deleted_at IS NULL AND e.deleted_at IS NULL");
                $this->stmt->execute([$nif]);

                $user = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($user) ? $user : null;
            } catch (PDOException $e) {
                throw $e;
            }          
        }

        //get user id
        public function get_user_id(string $nif) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE nif = ? LIMIT 1");
                $this->stmt->execute([$nif]);

                $id = $this->stmt->fetch(PDO::FETCH_ASSOC)['id'];

                return !empty($id) ? $id : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search users
        public function search_users(string $search) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, u.deleted_at, e.nome AS escola,
                    e.id AS escola_id, e.deleted_at AS estado_escola, c.role AS coordinator_role
                    FROM usuarios AS u
                    JOIN escolas AS e ON e.id = u.escola
                    LEFT JOIN coordenadores AS c ON c.id = u.id
                    WHERE u.nome LIKE ?
                ");
                
                $s = "%$search%";
                $this->stmt->execute([$s]);

                $users = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $users[] = $result;
                }

                return !empty($users) ? $users : null;
            } catch (PDOException $e) {
                throw $e;
            }   
        }

        //search school users
        public function search_school_users(string $search, int $school, string $role) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, u.deleted_at, e.nome AS escola,
                    e.id AS escola_id, e.deleted_at AS estado_escola, c.role AS coordinator_role
                    FROM usuarios AS u
                    JOIN escolas AS e ON e.id = u.escola
                    LEFT JOIN coordenadores AS c ON c.id = u.id
                    WHERE u.nome LIKE ? AND u.escola = ? AND u.role = ?
                ");
                
                $s = "%$search%";
                $this->stmt->execute([$s, $school, $role]);

                $users = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $users[] = $result;
                }

                return !empty($users) ? $users : null;
            } catch (PDOException $e) {
                throw $e;
            }   
        }
    }
?>