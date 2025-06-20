<?php
    require_once __DIR__ . "/../Model/AlbumManager.php";
    require_once __DIR__ . "/../Model/PhotoManager.php";

    class AlbumController{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function showCreate() {
            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/form_album.php';
            $content = ob_get_clean();

            include __DIR__ . '/../View/layout.php';
        }

        public function showAlbum() {
            $errors = [];
            $album_id = $_GET['id'] ?? null;

            $albumManager = new AlbumManager($this->pdo);
            $album = $albumManager->getAlbumById($album_id);

            $photoManager = new PhotoManager($this->pdo);
            $photos = $photoManager->getPhotosByAlbumId($album_id);

            if (isset($album_id) && $album['visibility'] == 'public' || $_SESSION['id'] === $album['owner_id']) {
                ob_start();
                include __DIR__ . '/../_partials/feed_navbar.php';
                $navbar = ob_get_clean();

                ob_start();
                include __DIR__ . '/../View/album.php';
                $content = ob_get_clean();

                include __DIR__ . '/../View/layout.php';

            } else {
                $errors[] = 'Une erreur c\'est produite lors de la récupération des données, veuillez réessayer.';
                $_SESSION["errors"] = $errors;
                header("Location: /profile");
                exit();
            }
        }

        public function showUpdate() {
            $errors = [];
            $album_id = $_GET['id'];

            $albumManager = new AlbumManager($this->pdo);
            $album = $albumManager->getAlbumById($album_id);

            $isSelected = null;
            if($_GET['action'] === 'update' && $album['visibility'] !== null) {
                $isSelected = $album['visibility'];
            }

            if(!empty($album)) {
                ob_start();
                include __DIR__ . '/../_partials/profile_navbar.php';
                $navbar = ob_get_clean();

                ob_start();
                include __DIR__ . '/../View/form_album.php';
                $content = ob_get_clean();

                include __DIR__ . '/../View/layout.php';
            } else {
                $errors[] = 'Une erreur c\'est produite lors de la récupération des donnée d\'un, veuillez réessayer.';
                $_SESSION["errors"] = $errors;
                header("Location: /album?id=" . $album_id);
                exit();
            }
        }

        public function update() {
            $errors = [];
            $album_id = $_POST['album_id'] ?? null;

            $albumManager = new AlbumManager($this->pdo);
            $album = $albumManager->getAlbumById($album_id);

            $title = $_POST['album_title'] ?? null;
            $description = $_POST['album_description'] ?? null;
            $visibility = $_POST['visibility'] ?? null;
            $album_cover_url = '';

            if (isset($album_id) && !empty($title) && !empty($description) && 
            !empty($visibility) && $_SESSION['id'] == $album['owner_id'] && empty($errors)) {
                $title = cleanString($title);
                $owner_id = $album['owner_id'];
                $new_album_cover_url = '';
                $description = cleanString($description);
                $visibility = cleanString($visibility);

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {

                    if(!empty($album['album_cover_url'])) {
                        $old_photo = $album['album_cover_url'];
                        $path = __DIR__ . '/../../public/' . $old_photo;
                        if (file_exists($path)) {
                            unlink($path); 
                        }
                    }

                    $photoManager = new PhotoManager($this->pdo);
                    $new_album_cover_url = $photoManager->checkAndConvertImage() ?? null;
                }

                if (empty($errors)) {
                    $albumManager->update($album_id, $title, $owner_id, $description, $visibility, $new_album_cover_url);

                    $success[] = 'L\'album a été modifier avec succès';
                    $_SESSION['success'] = $success;
                    header('Location: /album?id=' . $album_id);
                    exit();     
                } 
            } else {
                $errors[] = 'Merci de renseigner tout les champs';
            }

            $_SESSION["errors"] = $errors;
            header("Location: /update-album?action=id=" . $album_id);
            exit();
        }

        public function delete() {
            $errors = [];
            $album_id = $_GET['album_id'] ?? null;

            $albumManager = new AlbumManager($this->pdo);
            $album = $albumManager->getAlbumById($album_id);

            if (isset($album_id) && $_SESSION['id'] == $album['owner_id'] && empty($errors)) {
                $photoManager = new PhotoManager($this->pdo);
                $photos = $photoManager->getPhotosByAlbumId($album_id);
                
                foreach ($photos as $photo ) {
                    $photoManager->delete($photo['id']);
                    $path = __DIR__ . '/../../public/' . $photo['image_url'];
                    if (file_exists($path)) {
                        unlink($path); 
                    }
                }

                $albumManager->delete($album_id);

                $success[] = 'Album supprimer avec succès';
                $_SESSION['success'] = $success;
                header('Location: /profile');
                exit();              
            }else {
                $errors[] = 'Tous les champs sont obligatoires';
            }

            $_SESSION["errors"] = $errors;
            header("Location: /profile");
            exit();
        }

        public function create() {
            $errors = [];
            $title = $_POST['album_title'] ?? null;
            $description = $_POST['album_description'] ?? null;
            $add_photos = $_POST['add_photos'] ?? null;
            $visibility = $_POST['visibility'] ?? null;
            $album_cover_url = '';

            if(!empty($title) && !empty($description) 
            && !empty($visibility)){
                
                $title = cleanString($title);
                $owner_id = $_SESSION['id'];
                $description = cleanString($description);
                $date_creation = date('Y-m-d H:i:s');
                $visibility = cleanString($visibility);

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $photoManager = new PhotoManager($this->pdo);
                    $album_cover_url = $photoManager->checkAndConvertImage();
                }

                if(empty($errors)){
                    $albumManager = new AlbumManager($this->pdo);
                    $newAlbums = $albumManager->create($title, $owner_id, $description, $date_creation, $visibility, $album_cover_url);

                    if(!empty($add_photos)){
                        //envoyer au formulaire d'ajout de photo et gérer tout ça dans les fichier relier aux photos
                        header('Location: /create-photo?album_id=' . $newAlbums['id']);
                        exit();
                    }

                    header('Location: /profile');
                    exit();
                }                
            } else {
                $errors[] = 'Merci de renseigner tout les champs';
            }

            $_SESSION["errors"] = $errors;
            header("Location: /create-album");
            exit();
        }
    }
?>