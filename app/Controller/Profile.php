<?php
    require_once __DIR__ . "/../Model/AlbumManager.php";
    require_once __DIR__ . "/../Model/PhotoManager.php";
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

        public function showUpdate() {
            $errors = [];

            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/form_profile.php';
            $content = ob_get_clean();

            include __DIR__ . '/../View/layout.php';
        }

        public function update() {
            $errors = [];

            $username = $_POST['username'] ?? null;
            $new_pp_url = null;
            $description = $_POST['description'] ?? null;

            if (!empty($username) && isset($_FILES['photo']) && !empty($description) && 
            $_FILES['photo']['error'] === UPLOAD_ERR_OK && empty($errors)) {

                $username = cleanString($username);
                $new_pp_url = null;
                $description = cleanString($description);

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    
                    $path = __DIR__ . '/../../public/' . $_SESSION["profile_picture"];
                    if (file_exists($path)) {
                        unlink($path); 
                    }

                    $photoManager = new PhotoManager($this->pdo);
                    $new_pp_url = $photoManager->checkAndConvertImage();
                }

                if (empty($errors)) {
                    $User = new User($this->pdo);
                    $user = $User->update($_SESSION['id'], $username, $description, $new_pp_url);

                    if (empty($errors)) {
                        $_SESSION["username"] = $user['username'];
                        $_SESSION["description"] = $user['description'];
                        $_SESSION["profile_picture"] = !empty($user['profile_picture']) ? $user['profile_picture'] : '/assets/img/default-pp.jpg';

                        $success[] = 'Le profile a été modifier avec succès';
                        $_SESSION['success'] = $success;
                        header('Location: /profile');
                        exit();   
                        
                    } else {
                        $errors[] = 'Un problème et survenus lors de la modification de photo.';
                    }
                } 
            } else {
                $errors[] = 'Merci de renseigner tout les champs';
            }

            $_SESSION["errors"] = $errors;
            header("Location: /update-photo?action=update&id=" . $photo_id . '&album-id=' . $album_id);
            exit();
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