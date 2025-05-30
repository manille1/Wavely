<?php
    class Photo {
        private int $id;
        private string $name;
        private string $url;
        private string $description;
        private DateTime $date_upload;
        private int $creator_id;
        private string $visibility;

        public function __construct(int $id, string $name, string $url, string $description, DateTime $date_upload, int $creator_id, string $visibility) {
            $this->id = $id;
            $this->name = $name;
            $this->url = $url;
            $this->description = $description;
            $this->date_upload = $date_upload;
            $this->creator_id = $creator_id;
            $this->visibility = $visibility;
        }

        public function getAllPhotoAttributs():array {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'url' => $this->url,
                'description' => $this->description,
                'date_upload' => $this->date_upload,
                'creator_id' => $this->creator_id,
                'visibility' => $this->visibility
            ];
        }

        public function updatePhoto(PDO $pdo,int $id, string $name, string $url, string $description, DateTime $date_upload, int $creator_id, string $visibility):void {
            $query = "UPDATE photos
                    SET name = :name,
                        url = :url,
                        description = :description,
                        date_upload = :date_upload,
                        creator_id = :creator_id,
                        visibility = :visibility
                    WHERE id = :id";

            $prep = $pdo->prepare($query);
            $prep->execute(['name' => $name,
                        'url' => $url,
                        'description' => $description,
                        'date_upload' => $date_upload,
                        'creator_id' => $creator_id,
                        'visibility' => $visibility,
                        'id' => $id]);
        }

        public function deletePhoto(PDO $pdo, int $id):void {
            $query = "DELETE FROM photos
                    WHERE id = :id";

            $prep = $pdo->prepare($query);
            $prep->execute(['id' => $id]);
        }
    }
