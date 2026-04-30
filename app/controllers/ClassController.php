<?php
    class ClassController extends Controller {
        private $class, $name, $teacher, $school, $chat;

        public function __construct() {
            $this->class = new ClassModel;
            $this->chat = new ChatController;
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

        //get class data
        public function get_class_data(int $id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->class->get_class_data($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TURMA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
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