<?php
    class CoordinatorController extends TeacherController {
        private $coordinator;

        public function __construct() {
            $this->coordinator = new CoordinatorModel;
        }

        //insert a new coordinator
        public function add_coordinator($id) {
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
    }
?>