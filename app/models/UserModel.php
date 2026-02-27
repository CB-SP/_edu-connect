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
        public function edit_user($name, $contact_1, $contact_2, $nif, $email, $foto, $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE usuarios SET nome = ?, contacto_1 = ?, contacto_2 = ?, nif = ?, email = ?, foto = ? WHERE id = ?");

                return $this->stmt->execute([$name, $contact_1, $contact_2, $nif, $email, $foto, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search for every users of a school
        public function fetch_users() {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, e.nome AS escola FROM usuarios AS u JOIN escolas AS e ON u.escola = e.id WHERE u.deleted_at IS NULL");
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

        //delete users
        public function delete_user($id, $date) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE usuarios SET deleted_at = ? WHERE id = ?");

                return $this->stmt->execute([$date, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>