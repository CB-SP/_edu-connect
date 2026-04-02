<?php
    class CoordinatorModel extends Model {

        //insert a new coordinator
        public function add_coordinator($id, $role) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO coordenadores (id, role) VALUES (?, ?)");

                return $this->stmt->execute([$id, $role]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>