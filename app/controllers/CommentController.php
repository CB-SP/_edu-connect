<?php
    class CommentController extends Controller {
        private $comment, $content, $user, $post, $school;

        public function __construct() {
            $this->comment = new CommentModel;
        }

        //make a comment in a post
        public function comment() {
            $this->content = $_POST['content'] ?? null;
            $this->user = $_POST['user'] ?? null;
            $this->post = $_POST['post'] ?? null;
            $this->school = $_POST['school'] ?? null;

            if (empty($this->content) || empty($this->user) || empty($this->post) || empty($this->school)) {
                return false;
            }

            try {
                if (!$this->comment->comment($this->content, $this->user, $this->post, $this->school)) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_COMENTAR: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }
    }
?>