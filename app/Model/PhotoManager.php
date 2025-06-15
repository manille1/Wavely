<?php
    class PhotoManager{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getPhotosByAlbumId($albumId) {
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

        public function getPhotoById($photoId) {
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

        public function linkedPhotoToAlbum($photo_id, $album_id) {
            try {
                $stmt = $this->pdo->prepare('INSERT INTO photo_album (photo_id, album_id) VALUES (:photo_id, :album_id)');
                $stmt->bindParam(':photo_id', $photo_id);
                $stmt->bindParam(':album_id', $album_id);
                return $stmt->execute();
            } catch (Exception $e) {
                error_log("Erreur lors de la liaison photo à album : " . $e->getMessage());
                return false;
            }
        }

        public function attributePhotoRole($photo_id, $user_id, $role) {
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

        public function create($name, $image_url, $date_upload, $creator_id, $visibility, $description, $location) {
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
    }
?>