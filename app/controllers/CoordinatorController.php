<?php
    class CoordinatorController extends TeacherController {
        private $coordinator, $school, $student;

        public function __construct() {
            parent::__construct();
            $this->coordinator = new CoordinatorModel;
            $this->school = new SchoolController;
            $this->student = new StudentController;
        }

        //insert a new coordinator
        public function add_coordinator(int $id) {
            try {
                if (!$this->coordinator->add_coordinator($id, 'coordenador')) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_COORDENADOR: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        public function find_school(int $id) {
            return $this->school->find_school($id);
        }

        //==========users managemant==========
        //create
        public function add_student() {
            $this->redirect($this->add_user() ? 'teacher/painel' : 'teacher/painel');
        }

        //update
        public function edit_student() {
            $this->redirect($this->edit_user() ? 'teacher/painel' : 'teacher/painel');
        }

        //read all
        public function fetch_school_students(int $school) {
            return $this->student->fetch_school_students($school);
        }

        //read one
        public function fetch_student(int $id) {
            header('Content-Type: application/json');

            echo json_encode($this->fetch_user($id));
            exit;
        }

        //delete
        public function delete_student(int $id) {
            $this->redirect($this->delete_user($id) ? 'teacher/painel' : 'teacher/painel');
        }

        //restore
        public function restore_student(int $id) {
            $this->redirect($this->restore_user($id) ? 'teacher/painel' : 'teacher/painel');
        }

        //get total students of a school
        public function get_total_students(int $school) {
            return $this->student->get_total_students($school);
        }
    }
?>