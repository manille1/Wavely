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
                $date_upload = date('Y-m-d H:i:s');
                $creator_id = $_SESSION['id'];
                $description = cleanString($description);
                $location = cleanString($location);

                $maxSize = 2 * 1024 * 1024; // 2Mo
                if ($_FILES['photo']['size'] > $maxSize) {
                    $errors[] = 'L’image dépasse la taille maximale autorisée (2 Mo).';
                    exit();
                }

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $fileTmp = $_FILES['photo']['tmp_name'];
                    $fileOriginalName = $_FILES['photo']['name'];
                    $fileExtension = strtolower(pathinfo($fileOriginalName, PATHINFO_EXTENSION));

                    $newFileName = bin2hex(random_bytes(8)) . date('Y-m-d_H-i-s') . '.webp';
                    $destination = __DIR__ . '/../../public/uploads/' . $newFileName;

                    if ($fileExtension === 'jpg' || $fileExtension === 'jpeg') {
                        $photo = imagecreatefromjpeg($fileTmp);
                        imagewebp($photo, $destination, 100);
                        imagedestroy($photo);

                    } else if ($fileExtension === 'png') {
                        $photo = imagecreatefrompng($fileTmp);
                        imagewebp($photo, $destination, 100);
                        imagedestroy($photo);

                    } else if ($fileExtension === 'webp') {
                        move_uploaded_file($fileTmp, $destination);

                    } else {
                        $errors[] = 'Format non pris en charge. Veuillez utiliser jpg, jpeg, png ou webp.';
                    }

                    $photo_url = 'uploads/' . $newFileName;

                } else {
                    var_dump($_FILES['photo']);
                    var_dump($_FILES['photo']['error']);
                    $errors[] = 'Erreur lors de l\'upload de la photo.';
                }

                if (empty($errors)) {
                    $photoManager = new PhotoManager($this->pdo);
                    $newPhoto = $photoManager->create($title, $photo_url, $date_upload, $creator_id, $visibility, $description, $location);

                    if ($newPhoto === false) {
                        $errors[] = 'Erreur lors de la création de la photo.';
                    } else {
                        $albumId = intval($_POST['album_id'] ?? 0);

                        $linked = $photoManager->linkedPhotoToAlbum($newPhoto['id'], $albumId);
                        $roleSet = $photoManager->attributePhotoRole($newPhoto['id'], $_SESSION['id'], 'owner');

                        if ($linked && $roleSet) {
                            header('Location: /profile');
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