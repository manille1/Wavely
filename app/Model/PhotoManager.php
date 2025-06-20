<?php
    class PhotoManager{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getVisiblePhotoForUser($user_id) {
            try {
                $stmt = $this->pdo->prepare("SELECT photos.*, users.username, 
                DATE(photos.date_upload) AS date_only FROM photos
                LEFT JOIN users ON photos.creator_id = users.id
                LEFT JOIN photo_roles ON photos.id = photo_roles.photo_id
                WHERE (photo_roles.user_id = :user_id AND photo_roles.role = 'viewer')
                OR photos.visibility = 'public'
                ORDER BY photos.date_upload DESC
                LIMIT 50;");

                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                return $errors[] = "Erreur lors de la recherche de photo pour le feed d'actualité {$e->getMessage()}";
            }
        }

        public function getPhotosByAlbumId(int $albumId) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM photos
                INNER JOIN photo_album ON photos.id = photo_album.photo_id 
                WHERE photo_album.album_id = :album_id;");

                $stmt->bindParam(':album_id', $albumId);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                return $errors[] = "Erreur lors de la recherche de photo liée à un album {$e->getMessage()}";
            }
        }

        public function getAlbumIdByPhotoId(int $photoId) {
            try {
                $stmt = $this->pdo->prepare("SELECT id FROM albums
                INNER JOIN photo_album AS pa ON albums.id = pa.album_id
                WHERE pa.photo_id = :photo_id;");

                $stmt->bindParam(':photo_id', $photoId);
                $stmt->execute();
                return (int) $stmt->fetchColumn();

            } catch (Exception $e) {
                return $errors[] = "Erreur lors de la recherche d'album liée à un photo {$e->getMessage()}";
            }
        }

        public function getPhotoById(int $photoId) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM photos WHERE id = :photo_id");
                $stmt->bindParam(':photo_id', $photoId);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                error_log("Erreur lors de la recherche de photo : " . $e->getMessage());
                return false;
            }
        }

        public function linkedPhotoToAlbum(int $photo_id, int $album_id) {
            try {
                $stmt = $this->pdo->prepare('INSERT INTO photo_album (`photo_id`, `album_id`) VALUES (:photo_id, :album_id)');
                $stmt->bindParam(':photo_id', $photo_id);
                $stmt->bindParam(':album_id', $album_id);
                return $stmt->execute();
            } catch (Exception $e) {
                error_log("Erreur lors de la liaison photo à album : " . $e->getMessage());
                return false;
            }
        }

        public function attributePhotoRole(int $photo_id, int $user_id, $role) {
            try {
                $stmt = $this->pdo->prepare('INSERT INTO photo_roles (photo_id, user_id, role) VALUES (:photo_id, :user_id, :role)');
                $stmt->bindParam(':photo_id', $photo_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':role', $role);
                return $stmt->execute();
            } catch (Exception $e) {
                error_log("Erreur lors de l'attribution de role à une photo : " . $e->getMessage());
                return false;
            }
        }

        public function create(string $name, string $image_url, string $date_upload, int $creator_id, string $visibility, string $description, string $location) {
            try {
                $state = $this->pdo->prepare('INSERT INTO photos (`name`, `image_url`, `date_upload`, `creator_id`, `visibility`, `description`, `location`) 
                    VALUES (:name, :image_url, :date_upload, :creator_id, :visibility, :description, :location)');

                $state->bindParam(':name', $name);
                $state->bindParam(':image_url', $image_url);
                $state->bindParam(':date_upload', $date_upload);
                $state->bindParam(':creator_id', $creator_id);
                $state->bindParam(':visibility', $visibility);
                $state->bindParam(':description', $description);
                $state->bindParam(':location', $location);
                $state->execute();

                $lastId = $this->pdo->lastInsertId();
                return $this->getPhotoById($lastId);

            } catch (Exception $e) {
                error_log("Erreur à la création de la photo : " . $e->getMessage());
                return false;
            }
        }

        public function update(int $photo_id, string $title, int $creator_id, string $description, string $visibility, string $image_url, string $location) {
            try {
                $state = $this->pdo->prepare('UPDATE photos
                SET `name` = :name, 
                `image_url` = :image_url,
                `visibility` = :visibility,
                `description` = :description,
                `location` = :location
                WHERE creator_id = :creator_id
                AND id = :photo_id;');

                $state->bindParam(':photo_id', $photo_id);
                $state->bindParam(':name', $title);
                $state->bindParam(':creator_id', $creator_id);
                $state->bindParam(':visibility', $visibility);
                $state->bindParam(':description', $description);
                $state->bindParam(':location', $location);
                $state->bindParam(':image_url', $image_url);
                $state->execute();

            } catch (Exception $e) {
                return $errors[] = "Erreur à la création de l'album {$e->getMessage()}";
            }
        }

        public function delete(int $photo_id) {
            try {
                $state = $this->pdo->prepare('DELETE FROM photos WHERE id = :id;');

                $state->bindParam(':id', $photo_id);
                $state->execute();
            } catch (Exception $e) {
                return $errors[] = "Erreur à la suppression de l'photo {$e->getMessage()}";
            }
        }

        public function checkAndConvertImage(){
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

                return $photo_url = 'uploads/' . $newFileName;

            } else {
                $errors[] = 'Erreur lors de l\'upload de la photo.';
            }
        }

    }
?>