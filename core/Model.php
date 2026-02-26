<?php
    class Model {
        protected $pdo, $stmt;

        public function __construct() {
            try {
                $this->pdo = Connection::connect();

                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Falha ao estabelecer conexão com o banco de dados: ". $e->getMessage());
            }
        }
    }
?>