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

        //confirm password
        public static function confirmPassword($password, $confirmPassword) {
            if ($password !== $confirmPassword) {
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

        public static function uploadAvatar() {

            if (!isset($_FILES['photo']) && !isset($_FILES['logo'])) {
                return null;
            }

            $file = $_FILES['photo'] ?? $_FILES['logo'];

            if ($file['error'] === 4) {
                return null;
            }

            if ($file['error'] !== 0) {
                return null;
            }

            if (!is_uploaded_file($file['tmp_name'])) {
                return null;
            }

            $name = $file['name'];
            $tmp = $file['tmp_name'];

            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png'];
            if (!in_array($extension, $allowed)) {
                return null;
            }

            $mime = mime_content_type($tmp);
            $allowedMime = ['image/jpeg', 'image/png'];

            if (!in_array($mime, $allowedMime)) {
                return null;
            }

            $newName = uniqid('avatar_', true) . "." . $extension;

            $uploadDir = __DIR__ . "/../../public/uploads/avatars/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $destination = $uploadDir . $newName;

            if (!move_uploaded_file($tmp, $destination)) {
                return null;
            }

            return "uploads/avatars/" . $newName;
        }
    }
?>