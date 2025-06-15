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
                return $errors[] = "Erreur lors de la recherche de l'album {$e->getMessage()}";
            }
        }

        // public function getAllAlbumsByUser($userId) {
        //     try {
        //         $stmt = $this->pdo->prepare("SELECT * FROM albums WHERE owner_id = ?");
        //         $stmt->execute([$userId]);
        //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     } catch (Exception $e) {
        //         return $errors[] = "Erreur lors de la recherche d'album de l'utilisateur {$e->getMessage()}";
        //     }
        // }

        public function create($title, $owner_id, $description, $date_creation, $visibility) {
            try {
                $state = $this->pdo->prepare('INSERT INTO albums (`name`, `owner_id`, `description`, `date_creation`, `visibility`) 
                VALUES (:name, :owner_id, :description, :date_creation, :visibility)');

                $state->bindParam(':name', $title);
                $state->bindParam(':owner_id', $owner_id);
                $state->bindParam(':description', $description);
                $state->bindParam(':date_creation', $date_creation);
                $state->bindParam(':visibility', $visibility);
                $state->execute();
            } catch (Exception $e) {
                return $errors[] = "Erreur à la création de l'album {$e->getMessage()}";
            }
        }
    }
?>