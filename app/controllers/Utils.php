<?php
    class Utils extends Controller {
        //verify users password
        public static function verify_password($password, $hash) {
            if (empty($password) || empty($hash)) {
                return false;
            }

            return password_verify($password, $hash);
        }
    }
?>