<?php
    class Utils extends Controller {
        //verify users password
        public static function verify_password($password, $hash) {
            if (empty($password) || empty($hash)) {
                return false;
            }

            return password_verify($password, $hash);
        }

        //verify password length
        public static function password_length($password) {
            if (empty($password)) {
                return false;
            }

            if (strlen($password) < 8) {
                return false;
            }

            return true;
        }

        //verify nif length
        public static function nif_length($nif) {
            if (empty($nif)) {
                return false;
            }

            if (strlen($nif) != 14) {
                return false;
            }

            return true;
        }

        //verify phone number length
        public static function phone_number_length($phone) {
            if (empty($phone)) {
                return false;
            }

            if (strlen($phone) != 16) {
                return false;
            }

            return true;
        }
    }
?>