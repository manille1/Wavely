<?php
    require_once __DIR__ . "/../Model/PhotoManager.php";

    class PhotoController{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function showCreate() {
            $album_id = intval($_GET['album_id'] ?? 0);
            
            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/create_photo.php';
            $content = ob_get_clean();

            include __DIR__ . '/../View/layout.php';
        }

        public function create() {
            $errors = [];
            $title = $_POST['photo_title'] ?? null;
            $photo_url = null;
            $description = $_POST['photo_description'] ?? null;
            $location = $_POST['photo_location'] ?? null;
            $visibility = $_POST['visibility'] ?? null;

            if (!empty($title) && isset($_FILES['photo']) && !empty($description) && !empty($visibility)) {
                
                $title = cleanString($title);
                $date_upload = date('Y/m/d H:i:s');
                $creator_id = $_SESSION['id'];
                $description = cleanString($description);
                $location = cleanString($location);

                $photoManager = new PhotoManager($this->pdo);
                $photo_url = $photoManager->checkAndConvertImage();

                if (empty($errors)) {
                    $newPhoto = $photoManager->create($title, $photo_url, $date_upload, $creator_id, $visibility, $description, $location);

                    if ($newPhoto === false) {
                        $errors[] = 'Erreur lors de la création de la photo.';
                    } else {
                        $albumId = intval($_POST['album_id'] ?? 0);
                        $albumId = cleanString($albumId);

                        $linked = $photoManager->linkedPhotoToAlbum($newPhoto['id'], $albumId);
                        $roleSet = $photoManager->attributePhotoRole($newPhoto['id'], $_SESSION['id'], 'owner');

                        if ($linked && $roleSet) {
                            header('Location: /album?id=' . $albumId);
                            exit();
                        } else {
                            $errors[] = 'Erreur lors de la liaison photo à l\'album ou de l\'attribution du rôle.';
                        }
                    }
                }
            } else {
                $errors[] = 'Merci de remplir tous les champs obligatoires.';
            }

            $_SESSION['errors'] = $errors;
            header('Location: /create-photo?album_id=' . intval($_GET['id'] ?? 0));
            exit();
        }
    }
?>