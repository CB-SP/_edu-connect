<?php
    class PrincipalModel extends Model {
        //fetch total entities
        public function total_entities($school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT
	                (SELECT COUNT(id) FROM usuarios WHERE escola = ? AND deleted_at IS NULL) AS school_users,
                    (SELECT COUNT(id) FROM usuarios WHERE escola = ? AND role = 'professor' AND deleted_at IS NULL) AS teachers,
                    (SELECT COUNT(id) FROM usuarios WHERE escola = ? AND role = 'aluno' AND deleted_at IS NULL) AS students
                ");
                $this->stmt->execute([$school, $school, $school]);

                $total_entities = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

                return !empty($total_entities) ? $total_entities : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>