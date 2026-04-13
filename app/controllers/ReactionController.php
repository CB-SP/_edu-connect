<?php
    class ReactionController extends Controller {
        private $reaction, $user, $post, $type;

        public function __construct() {
            $this->reaction = new ReactionModel;
        }

        //react in posts
        public function react() {
            $this->user = $_POST['user'] ?? null;
            $this->post = $_POST['post'] ?? null;
            $this->type = $_POST['type'] ?? null;

            if ((empty($this->user)) || (empty($this->post)) || (empty($this->type))) {
                return false;
            }

            try {
                $react = $this->isReacted($this->user, $this->post);

                if (!empty($react) && $react !== 'none') {
                    if (!$this->update_reaction($this->user, $this->post, $this->type)) {
                        return false;
                    }

                    return true;
                }

                if (!empty($react) && $react === 'none') {
                    if (!$this->delete_reaction($this->user, $this->post, $this->type)) {
                        return false;
                    }

                    return true;
                }

                if (!$this->reaction->react($this->user, $this->post, $this->type)) {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("ERRO_REAGIR: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }

            return true;
        }

        //get user reactions
        public function get_reactions($user, $post) {
            if (empty($user) || empty($post)) {
                return null;
            }

            try {
                return $this->reaction->get_reactions($user, $post);
            } catch (PDOException $e) {
                error_log("ERRO_BUSCAR_REACOES_USUARIO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }

        //update reaction
        private function update_reaction($user, $post, $type) {
            try {
                if (!$this->reaction->update_reaction($user, $post, $type)) {
                    return false;
                }

                return true;
            } catch (PDOException $e) {
                error_log("ERRO_ACTUALIZAR_REACAO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }
        }

        //delete reaction
        private function delete_reaction($user, $post) {
            try {
                if (!$this->reaction->delete_reaction($user, $post)) {
                    return false;
                }

                return true;
            } catch (PDOException $e) {
                error_log("ERRO_APAGAR_REACAO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return false;
            }
        }

        //verify if the post is allready reacted
        private function isReacted($user, $post) {
            if ((empty($user)) || (empty($post))) {
                return false;
            }
            
            try {
                $type = $this->reaction->isReacted($user, $post);

                if (empty($type)) {
                    return null;
                }

                if ((($type === $this->type) && ($this->type === 'like')) || (($type === $this->type) && ($this->type === 'adoro'))) {
                    return 'none';
                }
                
                if (($type !== $this->type) && ($this->type === 'like')) {
                    return 'like';
                }

                return 'adoro';
            } catch (PDOException $e) {
                error_log("ERRO_VERIFICAR_REACAO: ". $e->getMessage(). "\n". $e->getTraceAsString());
                return null;
            }
        }
    }
?>