<?php
    class Album {
        private int $id;
        private string $name;
        private int $owner_id;
        private DateTime $date_creation;
        private string $description;
        private string $visibility;

        public function __construct(int $id, string $name, int $owner_id, DateTime $date_creation, string $description, string $visibility) {
            $this->id = $id;
            $this->name = $name;
            $this->owner_id = $owner_id;
            $this->date_creation = $date_creation;
            $this->description = $description;
            $this->visibility = $visibility;
        }

        public function getAllAlbumAttributs():array {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'owner_id' => $this->owner_id,
                'date_creation' => $this->date_creation,
                'description' => $this->description,
                'visibility' => $this->visibility
            ];
        }

        public function updateAlbum(PDO $pdo, int $id, string $name, int $owner_id, DateTime $date_creation, string $description, string $visibility):void {
            $query = "UPDATE albums
                    SET name = :name,
                        owner_id = :owner_id,
                        date_creation = :date_creation,
                        description = :description,
                        visibility = :visibility
                    WHERE id = :id";

            $prep = $pdo->prepare($query);
            $prep->execute(['name' => $name,
                        'owner_id' => $owner_id,
                        'date_creation' => $date_creation,
                        'description' => $description,
                        'visibility' => $visibility,
                        'id' => $id]);
        }

        public function deleteAlbum(PDO $pdo, int $id):void {
            $query = "DELETE FROM albums
                    WHERE id = :id";

            $prep = $pdo->prepare($query);
            $prep->execute(['id' => $id]);
        }
    }
