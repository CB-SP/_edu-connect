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

            try {
                if (!($this->school->add_school($name, $address, $contact_1, $contact_2, $logo))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_ESCOLA". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }
    }
?>