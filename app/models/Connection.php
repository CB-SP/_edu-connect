<?php
    class Connection {
        public static function connect() {
            try {
                $pdo = new PDO("mysql:dbname=". DB_NAME. ";host=". DB_HOST. ";charset=utf8", DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }
?>