<?php
    class User {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function findByEmail(string $email): ?array {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        }

        public function findById(int $id): ?array {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        }

        public function findByUsername(string $username): ?array {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        }

        public function create(string $email, string $username, string $password, 
        string $profile_picture, string $description) {
            try {
                $role = 'user';
                
                $state = $this->pdo->prepare('INSERT INTO users (`email`, `password`, `username`, 
                `description`, `role`, `profile_picture`) 
                VALUES (:email, :password, :username, :description, :role, :profile_picture)');

                $state->bindParam(':email', $email);
                $state->bindParam(':password', $password);
                $state->bindParam(':username', $username);
                $state->bindParam(':description', $description);
                $state->bindParam(':role', $role);
                $state->bindParam(':profile_picture', $profile_picture);
                $state->execute();
            } catch (Exception $e) {
                return $errors[] = "Erreur à la création du user {$e->getMessage()}";
            }
        }

        public function update(int $id, string $username, string $description, string $profile_picture) {
            try {
                $state = $this->pdo->prepare('UPDATE users
                SET `username` = :username, 
                `description` = :description,
                `profile_picture` = :profile_picture
                WHERE id = :id;');

                $state->bindParam(':id', $id);
                $state->bindParam(':username', $username);
                $state->bindParam(':description', $description);
                $state->bindParam(':profile_picture', $profile_picture);
                $state->execute();
                
                return $this->findById($id);

            } catch (Exception $e) {
                return $errors[] = "Erreur à la modification du profile utilisateur {$e->getMessage()}";
            }
        }

        public function getOtherUsers($user_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id != :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user ?: null;
        }
    }
