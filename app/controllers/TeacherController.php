<?php
    class TeacherController extends UserController {
        public function classes() {
            $this->isLoged();
            $this->show_page("classes");
        }
    }
?>