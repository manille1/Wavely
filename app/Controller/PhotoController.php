<?php
    require_once __DIR__ . "/../Model/PhotoManager.php";

    class PhotoController{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function showCreate() {
            $album_id = intval($_GET['album_id'] ?? 0);
            $photo_id = intval($_GET['id'] ?? 0);
            
            ob_start();
            include __DIR__ . '/../_partials/profile_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/form_photo.php';
            $content = ob_get_clean();

            include __DIR__ . '/../View/layout.php';
        }

        public function showUpdate() {
            $errors = [];
            $album_id = intval($_GET['album_id'] ?? 0);
            $photo_id = intval($_GET['id'] ?? 0);

            $photoManager = new PhotoManager($this->pdo);
            $photo = $photoManager->getPhotoById($photo_id);

            $isSelected = null;
            if($_GET['action'] === 'update' && $photo['visibility'] !== null) {
                $isSelected = $photo['visibility'];
            }

            if(!empty($photo)) {
                ob_start();
                include __DIR__ . '/../_partials/profile_navbar.php';
                $navbar = ob_get_clean();

                ob_start();
                include __DIR__ . '/../View/form_photo.php';
                $content = ob_get_clean();

                include __DIR__ . '/../View/layout.php';

            } else {
                $errors[] = 'Une erreur c\'est produite lors de la récupération des donnée d\'une photo, veuillez réessayer.';
                $_SESSION["errors"] = $errors;
                header("Location: /album?id=" . $album_id);
                exit();
            }
        }

        public function update() {
            $errors = [];
            $album_id = $_POST['album_id'] ?? null;
            $photo_id = $_POST['photo_id'] ?? null;

            $photoManager = new PhotoManager($this->pdo);
            $photo = $photoManager->getPhotoById($photo_id);

            $title = $_POST['photo_title'] ?? null;
            $new_photo_url = null;
            $description = $_POST['photo_description'] ?? null;
            $location = $_POST['photo_location'] ?? null;
            $visibility = $_POST['visibility'] ?? null;

            if (!empty($title) && isset($_FILES['photo']) && !empty($description) && 
            !empty($visibility) && $_FILES['photo']['error'] === UPLOAD_ERR_OK && 
            $_SESSION['id'] == $photo['creator_id'] && empty($errors)) {

                $title = cleanString($title);
                $new_photo_url = null;
                $owner_id = $photo['creator_id'];
                $description = cleanString($description);
                $visibility = cleanString($visibility);

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {

                    $old_photo = $photo;
                    $path = __DIR__ . '/../../public/' . $old_photo['image_url'];
                    if (file_exists($path)) {
                        unlink($path); 
                    }
                    $old_photo = $photoManager->delete($old_photo['id']);

                    $new_photo_url = $photoManager->checkAndConvertImage();
                }

                if (empty($errors)) {
                    $photoManager->update($photo_id, $title, $owner_id, $description, $visibility, $new_photo_url);

                    $success[] = 'photo Modifier avec succès';
                    $_SESSION['success'] = $success;
                    //header('Location: /album?id=' . $album_id);
                    exit();     
                } 
            } else {
                $errors[] = 'Merci de renseigner tout les champs';
            }

            $_SESSION["errors"] = $errors;
            header("Location: /update-photo?action=update&id=" . $photo_id . '&album-id=' . $album_id);
            exit();
        }

        public function delete() {
            $errors = [];
            $photo_id = $_GET['photo_id'] ?? null;

            $photoManager = new PhotoManager($this->pdo);
            $photo = $photoManager->getPhotoById($photo_id);

            if (isset($photo_id) && $_SESSION['id'] == $photo['creator_id'] && empty($errors)) {
                $albumId = $photoManager->getAlbumIdByPhotoId($photo_id);
                $path = __DIR__ . '/../../public/' . $photo['image_url'];
                if (file_exists($path)) {
                    unlink($path); 
                }

                $photoManager->delete($photo_id);

                $success[] = 'Photo supprimer avec succès';
                $_SESSION['success'] = $success;
                header('Location: /album?id=' . $albumId);
                exit();              
            }
        }

        public function create() {
            $errors = [];
            $title = $_POST['photo_title'] ?? null;
            $photo_url = null;
            $description = $_POST['photo_description'] ?? null;
            $location = $_POST['photo_location'] ?? null;
            $visibility = $_POST['visibility'] ?? null;

            if (!empty($title) && isset($_FILES['photo']) && 
            !empty($description) && !empty($visibility) &&
            $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                
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

                        var_dump($albumId);
                        var_dump($newPhoto['id']);
                        $linked = $photoManager->linkedPhotoToAlbum($newPhoto['id'], $albumId);
                        $roleSet = $photoManager->attributePhotoRole($newPhoto['id'], $_SESSION['id'], 'owner');

                        if ($linked && $roleSet) {
                            header('Location: /album?id=' . $albumId);
                            exit();
                        } else {
                            $errors[] = 'Erreur lors de la liaison photo à album ou de l\'attribution du rôle.';
                        }
                    }
                }
            } else {
                $errors[] = 'Merci de remplir tous les champs obligatoires.';
            }

            $_SESSION['errors'] = $errors;
            header('Location: /create-photo?action=create&album_id=' . intval($_GET['id'] ?? 0));
            exit();
        }
    }
?>