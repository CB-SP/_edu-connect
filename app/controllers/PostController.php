<?php
    class PostController extends Controller {
        private $post, $content, $type, $user, $school;

        public function __construct() {
            $this->post = new PostModel;
        }

        //make a post
        public function publish() {
            $this->content = $_POST['content'] ?? null;
            $this->type = $_POST['type'] ?? null;
            $this->user = $_POST['user'] ?? null;
            $this->school = $_POST['school'] ?? null;

            if ((empty($this->content)) || (empty($this->type)) || (empty($this->user)) || (empty($this->school))) {
                return false;
            }

            try {
                if (!$this->post->publish($this->content, $this->type, $this->user, $this->school)) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_PUBLICAR_POST: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //get all posts of a school
        public function get_posts($school) {
            try {
                return $this->post->get_posts($school);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_POSTS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //get publications count
        public function count_publications($school) {
            try {
                return $this->post->count_publications($school);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_QUANTIDADE_POSTS: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
    }
?>