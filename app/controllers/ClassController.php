<?php
    class ClassController extends Controller {
        private $class, $name, $teacher, $school;

        public function __construct() {
            $this->class = new ClassModel;
        }

        //create a class
        public function create_class() {
            $this->name = $_POST['class_name'] ?? null;
            $this->teacher = $_POST['teacher'] ?? null;
            $this->school = $_POST['school'] ?? null;

            if (empty($this->name) || empty($this->teacher) || empty($this->school)) {
                $this->redirect("teacher/classes/error0");
            }

            try {
                if (!$this->class->create_class($this->name, $this->teacher, $this->school)) {
                    $this->redirect("teacher/classes/error1");
                }
            } catch (PDOException $e) {
                error_log("ERRO_CRIAR_TURMA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                $this->redirect("teacher/classes/error2");
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
    }
?>