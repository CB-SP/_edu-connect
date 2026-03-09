<?php
    class SchoolModel extends Model {

        //add schools
        public function add_school($name, $address, $contact_1, $contact_2, $logo) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO escolas (nome, endereco, contacto_1, contacto_2, logo) VALUES (?, ?, ?, ?, ?)");

                return $this->stmt->execute([$name, $address, $contact_1, $contact_2, $logo]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //edit schools
        public function edit_school($name, $address, $contact_1, $contact_2, $logo, $id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE escolas SET nome = ?, endereco = ?, contacto_1 = ?, contacto_2 = ?, logo = ? WHERE id = ?");

                return $this->stmt->execute([$name, $address, $contact_1, $contact_2, $logo, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search for every shools
        public function fetch_schools() {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id, nome, endereco, contacto_1, contacto_2, logo, deleted_at FROM escolas ORDER BY nome");
                $this->stmt->execute();

                $schools = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $schools[] = $result;
                }

                return !empty($schools) ? $schools : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //search for a unic school
        public function fetch_school($id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id, nome, endereco, contacto_1, contacto_2, logo, created_at FROM escolas WHERE id = ? AND deleted_at IS NULL");
                $this->stmt->execute([$id]);

                $school = $this->stmt->fetch(PDO::FETCH_ASSOC);

                return !empty($school) ? $school : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //delete schools
        public function delete_school($id) {
            try {
                $this->stmt = $this->pdo->prepare("UPDATE escolas SET deleted_at = ? WHERE id = ?");

                return $this->stmt->execute([DATE, $id]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>