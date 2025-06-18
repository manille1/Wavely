<?php
    require_once __DIR__ . "/../Model/AlbumManager.php";
    require_once __DIR__ . "/../Model/User.php";

    class Profile{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function show() {
            $albumManager = new AlbumManager($this->pdo);
            $albums = $albumManager->getAllAlbumsByUser($_SESSION['id']);

            $username = $_SESSION['username'];
            $profile_picture = $_SESSION['profile_picture'];
            $description = $_SESSION['description'];

            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/profile.php';
            $content = ob_get_clean();

            include  __DIR__ . '/../View/layout.php';
        }

        public function showOtherProfile() {
            if(!empty($_GET['id']) || !empty($_GET['username'])) {
                $id = $_GET['id'];
                $username = cleanString($_GET['username']);

                $User = new User($this->pdo);
                $user = $User->findByUsername($username);

                $profile_picture = $user['profile_picture'];
                $description = $user['description'];

                $albumManager = new AlbumManager($this->pdo);
                $albums = $albumManager->getAllAlbumsByUser($id);

                ob_start();
                include __DIR__ . '/../_partials/feed_navbar.php';
                $navbar = ob_get_clean();

                ob_start();
                include __DIR__ . '/../View/profile.php';
                $content = ob_get_clean();

                include  __DIR__ . '/../View/layout.php';
            } else {
                header("Location: /feed");
            }
            
        }
    }
?>