<?php
    class Profile{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function show() {
            require_once __DIR__ . '/../Model/AlbumManager.php';

            $albumManager = new AlbumManager($this->pdo);
            $albums = $albumManager->getAllAlbumsByUser($_SESSION['id']);

            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/profile.php';
            $content = ob_get_clean();

            include  __DIR__ . '/../View/layout.php';
        }
    }
?>