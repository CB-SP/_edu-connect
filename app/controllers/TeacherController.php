<?php
class TeacherController extends UserController
{
    public function classes()
    {
        $this->isLoged();
        Utils::private_route('professor');
        $this->show_page("classes");
    }

    public function painel()
    {
        $this->isLoged();
        Utils::private_route('professor');
        $this->show_page("painel");
    }

    public function class(int $id)
    {
        $this->isLoged();
        Utils::private_route('professor');
        $_SESSION['class_id'] = $id;
        $this->show_page("class");
    }
    
}
