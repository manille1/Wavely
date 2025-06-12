<?php
    class Feed {
        public function showFeed() {
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