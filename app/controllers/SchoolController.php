<?php
    class SchoolController extends Controller {
        private $school;

        public function __construct() {
            $this->school = new SchoolModel;
        }

        //add schools
        public function add_school($name, $address, $contact_1, $contact_2, $logo) {
            if (empty($name) || empty($address) || empty($contact_1)) {
                return false;
            }

            if (!Utils::phone_number_length($contact_1) || (!empty($contact_2) && !Utils::phone_number_length($contact_2))) {
                return false;
            }

            try {
                if (!($this->school->add_school($name, $address, $contact_1, empty($contact_2) ? null : $contact_2, $logo))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_ESCOLA". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //edit shools
        public function edit_school($name, $address, $contact_1, $contact_2, $logo, $id) {
            if (empty($name) || empty($address) || empty($contact_1) || empty($id)) {
                return false;
            }

            if (!Utils::phone_number_length($contact_1) || (!empty($contact_2) && !Utils::phone_number_length($contact_2))) {
                return false;
            }

            try {
                if (!($this->school->edit_school($name, $address, $contact_1, empty($contact_2) ? null : $contact_2, $logo, $id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_EDITAR_ESCOLA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //search for every schools
        public function fetch_schools() {
            try {
                return $this->school->fetch_schools();
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_ESCOLAS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //search for a unic school
        public function fetch_school($id) {
            if (empty($id)) {
                return null;
            }

            try {
                header('Content-Type: application/json');
                echo json_encode($this->school->fetch_school($id));
                exit;
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_ESCOLA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                
                echo json_encode(['error' => 'Erro ao buscar escola']);
                exit;
            }
        }

        //delete schools
        public function delete_school($id) {
            if (empty($id)) {
                return false;
            }

            try {
                if (!($this->school->delete_school($id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_DELETAR_ESCOLA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //restore schools
        public function restore_school($id) {
            if (empty($id)) {
                return false;
            }

            try {
                if (!($this->school->restore_school($id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_RESTAURAR_ESCOLA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }
    }
?>