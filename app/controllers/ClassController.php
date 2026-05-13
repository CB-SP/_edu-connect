<?php
    class ClassController extends Controller {
        private $class, $name, $teacher, $school, $chat, $student;

        public function __construct() {
            $this->class = new ClassModel;
            $this->chat = new ChatController;
            $this->student = new StudentController;
        }

        //create a class
        public function create_class() {
            $this->name = $_POST['class_name'] ?? null;
            $this->teacher = $_POST['teacher'] ?? null;
            $this->school = $_POST['school'] ?? null;

            if (empty($this->name) || empty($this->teacher) || empty($this->school)) {
                $this->redirect("teacher/classes/error");
            }

            try {
                if (!$this->class->create_class($this->name, $this->teacher, $this->school)) {
                    $this->redirect("teacher/classes/error");
                }

                if (!$this->chat->create_chat($this->get_class_id($this->name), $this->school)) {
                    $this->redirect("teacher/classes/error");
                }
            } catch (PDOException $e) {
                error_log("ERRO_CRIAR_TURMA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("teacher/classes/error");
            }

            $this->redirect("teacher/classes");
        }

        //get teachers classes
        public function get_teachers_classes(int $id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->class->get_teachers_classes($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMAS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //search teachers classes
        public function search_teachers_classes(string $term, int $id) {
            try {
                header('Content-Type: application/json');

                $t = $term;

                $classes = null;

                $classes = $this->class->search_teachers_classes($t, $id);

                echo json_encode([
                    'success' => true,
                    'classes' => $classes
                ]);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMAS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //get class students
        public function get_class_students(int $id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->class->get_class_students($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //get students classes
        public function get_students_classes(int $id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->class->get_students_classes($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMAS_ESTUDANTES: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
        
        //search students classes
        public function search_students_classes(string $term, int $id) {
            try {
                header('Content-Type: application/json');

                $t = $term;

                $classes = null;

                $classes = $this->class->search_students_classes($t, $id);

                echo json_encode([
                    'success' => true,
                    'classes' => $classes
                ]);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMAS_ESTUDANTES: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //get class data
        public function get_class_data(int $id, int $school) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->class->get_class_data($id, $school);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //get all students of a school
        public function fetch_school_students(int $school) {
            return $this->student->fetch_school_students($school);
        }

        //add class student
        public function add_class_student(int $student, int $class) {
            if (empty($student) || empty($class)) {
                $this->redirect("teacher/class/$class/error");
            }

            try {
                if (!($this->class->add_class_student($student, $class))) {
                    $this->redirect("teacher/class/$class/error");
                }

            } catch (PDOException $e) {
                error_log("ERRO_ADICIONAR_ALUNO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("teacher/class/$class/error");
            }

            $this->redirect("teacher/class/$class");
        }

        //remove class student
        public function remove_class_student(int $student, int $class) {
            if (empty($student) || empty($class)) {
                $this->redirect("teacher/class/$class/error");
            }

            try {
                if (!($this->class->remove_class_student($student, $class))) {
                    $this->redirect("teacher/class/$class/error");
                }

            } catch (PDOException $e) {
                error_log("ERRO_ADICIONAR_ALUNO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("teacher/class/$class/error");
            }

            $this->redirect("teacher/class/$class");
        }

        //get class id
        private function get_class_id(string $name) {
            if (empty($name)) {
                return null;
            }

            try {
                return $this->class->get_class_id($name);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
    }
?>