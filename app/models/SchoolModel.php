<?php
    class SchoolModel extends Model {
        public function add_school($name, $address, $contact_1, $contact_2, $logo) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO escolas (nome, endereco, contacto_1, contacto_2, logo) VALUES (?, ?, ?, ?, ?)");

                return $this->stmt->execute([$name, $address, $contact_1, $contact_2, $logo]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>