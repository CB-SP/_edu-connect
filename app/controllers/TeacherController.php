<?php
    class TeacherController extends UserController {
        public function classes() {
            $this->isLoged();
            Utils::private_route('professor');
            $this->show_page("classes");
        }
    }
?>