<?php
    class CoordinatorModel extends Model {

        //insert a new coordinator
        public function add_coordinator(int $id, string $role) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO coordenadores (id, role) VALUES (?, ?)");

                return $this->stmt->execute([$id, $role]) ? true : false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>