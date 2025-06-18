<?php
    class AlbumManager{
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getAlbumById(int $albumId) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM albums WHERE id = ?");
                $stmt->execute([$albumId]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return $errors[] = "Erreur lors de la recherche de l'album {$e->getMessage()}";
            }
        }

        public function getAllAlbumsByUser(int $userId) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM albums WHERE owner_id = ?");
                $stmt->execute([$userId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return $errors[] = "Erreur lors de la recherche d'album de l'utilisateur {$e->getMessage()}";
            }
        }

        public function create(string $title, int $owner_id, string $description, string $date_creation, string $visibility, string $album_cover_url) {
            try {
                $state = $this->pdo->prepare('INSERT INTO albums (`name`, `owner_id`, `description`, `date_creation`, `visibility`, `album_cover_url`) 
                VALUES (:name, :owner_id, :description, :date_creation, :visibility, :album_cover_url)');

                $state->bindParam(':name', $title);
                $state->bindParam(':owner_id', $owner_id);
                $state->bindParam(':description', $description);
                $state->bindParam(':date_creation', $date_creation);
                $state->bindParam(':visibility', $visibility);
                $state->bindParam(':album_cover_url', $album_cover_url);
                $state->execute();

                $lastId = $this->pdo->lastInsertId();
                return $this->getAlbumById($lastId);

            } catch (Exception $e) {
                return $errors[] = "Erreur à la création de l'album {$e->getMessage()}";
            }
        }

        public function delete(int $album_id) {
            try {
                $state = $this->pdo->prepare('DELETE FROM albums WHERE id = :id;');

                $state->bindParam(':id', $album_id);
                $state->execute();
            } catch (Exception $e) {
                return $errors[] = "Erreur à la suppression de l'album {$e->getMessage()}";
            }
        }
    }
?>