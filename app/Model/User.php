<?php
    class User {
        public static function findByEmail(PDO $pdo, string $email): ?array {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        }

        public static function findByUsername(PDO $pdo, string $username): ?array {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        }

        public static function create(PDO $pdo, string $email, string $username, string $password, string $profile_picture, string $description) {
            try {
                $role = 'user';
                
                $state = $pdo->prepare('INSERT INTO users (`email`, `password`, `username`, `description`, `role`, `profile_picture`) 
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
    }
