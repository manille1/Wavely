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
            include __DIR__ . '/../View/create_album.php';
            $content = ob_get_clean();

            include __DIR__ . '/../View/layout.php';
        }

        public function showAlbum() {
            $album_id = $_GET['id'] ?? null;
            $album_id = cleanString($album_id);

            $albumManager = new AlbumManager($this->pdo);
            $album = $albumManager->getAlbumById($album_id);

            $photoManager = new PhotoManager($this->pdo);
            $photos = $photoManager->getPhotosByAlbumId($album_id);

            if (isset($album_id) && $_SESSION['id'] == $album['owner_id']) {
                ob_start();
                include __DIR__ . '/../_partials/feed_navbar.php';
                $navbar = ob_get_clean();

                ob_start();
                include __DIR__ . '/../View/album.php';
                $content = ob_get_clean();

                include __DIR__ . '/../View/layout.php';
            }
        }

        public function delete() {
            $errors = [];
            $album_id = $_GET['album_id'] ?? null;

            $albumManager = new AlbumManager($this->pdo);
            $album = $albumManager->getAlbumById($album_id);

            if (isset($album_id) && $_SESSION['id'] == $album['owner_id'] && empty($errors)) {
                $albumManager->delete($album_id);

                var_dump('tout est censé être supprimer');
                header('Location: /profile');
                exit();              
            }
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

                    var_dump($album_cover_url);
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
            }

            $_SESSION["errors"] = $errors;
            header("Location: /profile");
            exit();
        }
    }
?>