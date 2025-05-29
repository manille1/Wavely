<?php
    class Login {
        public function show() {
            $navbar = __DIR__ . '/../_partials/login_navbar.php';
            $content =  __DIR__ . '/../View/login.php';
            include  __DIR__ . '/../View/layout.php';
        }
    }
?>