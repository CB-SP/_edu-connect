<?php
    class StudentModel extends Model {
        //get all students of a school
        public function fetch_school_students(int $school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT u.id, u.nome, u.contacto_1, u.contacto_2, u.nif, u.email, u.foto, u.role, u.deleted_at, e.nome AS escola, e.id AS escola_id, e.deleted_at AS estado_escola
                    FROM usuarios AS u
                    JOIN escolas AS e ON u.escola = e.id
                    WHERE e.id = ? AND u.role = 'aluno'
                ");
                $this->stmt->execute([$school]);

                $students = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $students[] = $result;
                }

                return !empty($students) ? $students : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get total students of a school
        public function get_total_students(int $school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT COUNT(id) AS students
                    FROM usuarios
                    WHERE role = 'aluno' AND escola = ?
                ");
                $this->stmt->execute([$school]);

                $students = $this->stmt->fetch(PDO::FETCH_ASSOC)['students'];

                return !empty($students) ? $students : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>