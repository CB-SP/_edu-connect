<?php
    class SchoolController extends Controller {
        private $school, $id, $name, $address, $contact_1, $contact_2, $logo;

        public function __construct() {
            $this->school = new SchoolModel;
        }

        //add schools
        public function add_school() {
            $this->name  = $_POST['name'] ?? null;
            $this->address = $_POST['address'] ?? null;
            $this->contact_1 = $_POST['contact_1'] ?? null; 
            $this->contact_2 = $_POST['contact_2'] ?? null;

            if (empty($this->name) || empty($this->address) || empty($this->contact_1)) {
                return false;
            }

            if (!Utils::phone_number_length($this->contact_1) || (!empty($this->contact_2) && !Utils::phone_number_length($this->contact_2))) {
                return false;
            }

            $this->logo = Utils::uploadAvatar() ?? null;

            try {
                if (!($this->school->add_school($this->name, $this->address, $this->contact_1, empty($this->contact_2) ? null : $this->contact_2, $this->logo))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_ADD_ESCOLA". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //edit shools
        public function edit_school() {
            $this->id  = $_POST['id'] ?? null;
            $this->name  = $_POST['name'] ?? null;
            $this->address = $_POST['address'] ?? null;
            $this->contact_1 = $_POST['contact_1'] ?? null; 
            $this->contact_2 = $_POST['contact_2'] ?? null;

            $currentLogo = $_POST['current_logo'] ?? null;
            $newLogo = Utils::uploadAvatar() ?? null;

            if (empty($this->name) || empty($this->address) || empty($this->contact_1) || empty($this->id)) {
                return false;
            }

            if (!Utils::phone_number_length($this->contact_1) || (!empty($this->contact_2) && !Utils::phone_number_length($this->contact_2))) {
                return false;
            }

            if ($newLogo !== null) {
                $this->logo = $newLogo;

                if (!empty($currentLogo)) {
                    $oldPath = __DIR__ . "/../../public/" . $currentLogo;

                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

            } else {
                $this->logo = $currentLogo;
            }

            try {
                if (!($this->school->edit_school($this->name, $this->address, $this->contact_1, empty($this->contact_2) ? null : $this->contact_2, $this->logo, $this->id))) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_EDITAR_ESCOLA: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            $_SESSION['logo'] = $this->logo;
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
        public function fetch_school(int $id) {
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

        //search for a unic school
        public function find_school(int $id) {
            if (empty($id)) {
                return null;
            }

            try {
                return $this->school->fetch_school($id);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_ESCOLA: ". $e->getMessage(). "\n". $e->getTraceAsString());
            }
        }

        //delete schools
        public function delete_school(int $id) {
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
        public function restore_school(int $id) {
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

        //search schools
        public function search_schools(string $term) {
            header('Content-Type: application/json');

            $t = $term;

            $schools = null;

            $schools = $this->school->search_schools($t);

            echo json_encode([
                'success' => true,
                'schools' => $schools
            ]);
        }
    }
?>