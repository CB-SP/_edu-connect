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
                $this->stmt = $this->pdo->prepare("SELECT t.id, t.nome AS class, p.nome AS teacher, p.foto AS teacher_photo, COUNT(sc.id) AS students
                    FROM turmas AS t
                    JOIN usuarios AS p ON p.id = t.professor
                    LEFT JOIN alunos_turmas AS sc ON sc.turma = t.id
                    WHERE t.professor = ?
                    GROUP BY t.id
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

        //search teachers classes
        public function search_teachers_classes(string $search, int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT t.id, t.nome AS class, p.nome as teacher, p.foto AS teacher_photo, COUNT(sc.id) AS students
                    FROM turmas AS t
                    JOIN usuarios AS p ON p.id = t.professor
                    LEFT JOIN alunos_turmas AS sc ON sc.turma = t.id
                    WHERE t.professor = ? AND t.nome LIKE ?
                    GROUP BY t.id
                ");
                
                $s = "%$search%";
                $this->stmt->execute([$id, $s]);

                $classes = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $classes[] = $result;
                }

                return !empty($classes) ? $classes : null;
            } catch (PDOException $e) {
                throw $e;
            }  
        }

        //get class students
        public function get_class_students(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT s.id, s.nome, s.foto, s.email
                    FROM turmas AS c
                    JOIN usuarios AS t ON t.id = c.professor
                    JOIN alunos_turmas AS sc ON sc.turma = c.id
                    JOIN usuarios AS s ON s.id = sc.aluno
                    WHERE c.id = ?
                ");
                $this->stmt->execute([$id]);

                $students = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $students[] = $result;
                }
                
                return !empty($students) ? $students : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get students classes
        public function get_students_classes(int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT t.id, t.nome AS class, p.nome AS teacher, p.foto AS teacher_photo, COUNT(sc_all.id) AS students
                    FROM turmas AS t
                    JOIN usuarios AS p ON p.id = t.professor
                    JOIN alunos_turmas AS sc_filter ON sc_filter.turma = t.id
                    LEFT JOIN alunos_turmas AS sc_all ON sc_all.turma = t.id
                    WHERE sc_filter.aluno = ?
                    GROUP BY t.id, t.nome, p.nome
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

        //search students classes
        public function search_students_classes(string $search, int $id) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT t.id, t.nome AS class, p.nome AS teacher, p.foto AS teacher_photo, COUNT(sc_all.id) AS students
                    FROM turmas AS t
                    JOIN usuarios AS p ON p.id = t.professor
                    JOIN alunos_turmas AS sc_filter ON sc_filter.turma = t.id
                    LEFT JOIN alunos_turmas AS sc_all ON sc_all.turma = t.id
                    WHERE sc_filter.aluno = ? AND t.nome LIKE ?
                    GROUP BY t.id, t.nome, p.nome
                ");

                $s = "%$search%";
                $this->stmt->execute([$id, $s]);

                $classes = [];

                while ($result = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                    $classes[] = $result;
                }
                
                return !empty($classes) ? $classes : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get class data
        public function get_class_data(int $id, int $school) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT c.nome AS class, t.nome AS teacher, t.foto, COUNT(sc_all.id) AS students, (SELECT COUNT(id) FROM usuarios WHERE role = 'aluno' AND escola = ?) AS school_students
                    FROM turmas AS c
                    JOIN usuarios AS t ON t.id = c.professor
                    LEFT JOIN alunos_turmas AS sc_all ON sc_all.turma = c.id
                    WHERE c.id = ?
                ");
                $this->stmt->execute([$school, $id]);

                $class_data = $this->stmt->fetch(PDO::FETCH_ASSOC);
                
                return !empty($class_data) ? $class_data : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //get class chats
        public function get_class_id(string $name) {
            try {
                $this->stmt = $this->pdo->prepare("SELECT id FROM turmas WHERE nome = ?");
                $this->stmt->execute([$name]);

                $id = $this->stmt->fetch(PDO::FETCH_ASSOC)['id'];

                return !empty($id) ? $id : null;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //add class student
        public function add_class_student(int $student, int $class) {
            try {
                $this->stmt = $this->pdo->prepare("INSERT INTO alunos_turmas (aluno, turma) VALUES (?, ?)");
                
                return $this->stmt->execute([$student, $class]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }

        //remove class student
        public function remove_class_student(int $student, int $class) {
            try {
                $this->stmt = $this->pdo->prepare("DELETE FROM alunos_turmas WHERE aluno = ? AND turma = ? LIMIT 1");
                
                return $this->stmt->execute([$student, $class]) ?: false;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>