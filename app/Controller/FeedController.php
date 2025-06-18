<?php
    require_once __DIR__ . "/../Model/PhotoManager.php";

    class FeedController {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function showFeed() {
            $user_id = $_SESSION['id'];

            $photoManager = new PhotoManager($this->pdo);
            $photos_feed = $photoManager->getVisiblePhotoForUser($user_id);

            ob_start();
            include __DIR__ . '/../_partials/feed_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/feed.php';
            $content = ob_get_clean();

            include  __DIR__ . '/../View/layout.php';
        }
    }
?>