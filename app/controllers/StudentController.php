<?php
    class StudentController extends UserController {
        private $student;

        public function __construct() {
            $this->student = new StudentModel;
        }

        public function messages() {
            $this->isLoged();
            Utils::private_route('aluno');
            $this->show_page("messages");
        }

        public function classes() {
            $this->isLoged();
            Utils::private_route('aluno');
            $this->show_page("classes");
        }
       
        public function class() {
            $this->isLoged();
            Utils::private_route('aluno');
            $this->show_page("class");
        }

        //get all students of a school
        public function fetch_school_students(int $school) {
            try {
                return $this->student->fetch_school_students($school);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_ESTUDANTES: ". $e->getMessage(). "\n". $e->getTraceAsString());
            }
        }

        //get total students of a school
        public function get_total_students(int $school) {
            try {
                return $this->student->get_total_students($school);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_TOTAL_ESTUDANTES: ". $e->getMessage(). "\n". $e->getTraceAsString());
            }
        }
    }
?>