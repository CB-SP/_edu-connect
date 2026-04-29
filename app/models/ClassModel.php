<?php
    class ClassModel extends Model {
        //create a class
        public function create_class(string $name, int $teacher, int $school) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO turmas (nome, escola, professor) VALUES (?, ?, ?)");

                return $this->stmt->execute([$name, $school, $teacher]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get teachers classes
        public function get_teachers_classes(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT t.nome AS class, p.nome as teacher, COUNT(sc.id) AS students
                    FROM turmas AS t
                    JOIN usuarios AS p ON p.id = t.professor
                    JOIN alunos_turmas AS sc ON sc.turma = t.id
                    WHERE t.professor = ?
                    GROUP BY t.nome
                ");
                $this->stmt->execute([$id]);

                $classes = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $classes[] = $result;
                }

                return !empty($classes) ? $classes : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>