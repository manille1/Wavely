<?php
    class PhotoController{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function showCreate() {
            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/create_photo.php';
            $content = ob_get_clean();

            include __DIR__ . '/../View/layout.php';
        }
    }
?>