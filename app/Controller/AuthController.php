<?php
    require_once __DIR__ . "/../Model/User.php";
    require_once __DIR__ . "/../Model/PhotoManager.php";

    class AuthController {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function showLogin() {
            ob_start();
            include __DIR__ . '/../_partials/login_navbar.php';
            $navbar = ob_get_clean();

            ob_start();
            include __DIR__ . '/../View/login.php';
            $content = ob_get_clean();

            include  __DIR__ . '/../View/layout.php';
        }

        public function login() {
            $errors = [];
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if(null === $email || null === $password) {
                $errors[] = "identifiant ou mot de passe vide";
            } else {
                $User = new User($this->pdo);
                $user = $User->findByEmail($email);
        
                if (!$user || !password_verify($password, $user['password'])) {
                    $errors[] = "Erreur d'identification, veuillez essayer à nouveau";
                } else {
                    $_SESSION["auth"] = true;
                    $_SESSION["id"] = $user['id'];
                    $_SESSION["username"] = $user['username'];
                    $_SESSION["description"] = $user['description'];
                    $_SESSION["profile_picture"] = !empty($user['profile_picture']) ? $user['profile_picture'] : '/assets/img/default-pp.jpg';

                    header("Location: /feed");
                    exit();
                }
            }
            
            $_SESSION["errors"] = $errors;
            header("Location: /");
            exit();
        }

        public function register() {
            $errors = [];
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $confirmation = $_POST['confirmation'] ?? null;
            $username = $_POST['username'] ?? null;
            $photo_url = null;
            $description = $_POST['description'] ?? null;

            if (!empty($username) && !empty($email) &&
                !empty($password) && !empty($confirmation) && 
                isset($_FILES['photo']) && !empty($description) &&
                $_FILES['photo']['error'] === UPLOAD_ERR_OK){

                    $username = cleanString($username);
                    $email = cleanString($email);
                    $password = cleanString($password);
                    $confirmation = cleanString($confirmation);
                    $description = cleanString($description);

                    $photoManager = new PhotoManager($this->pdo);
                    $profile_picture_url = $photoManager->checkAndConvertImage();

                    var_dump('ça passe');

                    if ($confirmation !== $password) {
                        $errors[] = 'Le mot de passe et sa confirmation sont différents';
                    } else {
                        $confirmation = null;
                        $password = password_hash($password, PASSWORD_DEFAULT);
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'email invalide';
                    }

                    $User = new User($this->pdo);

                    if ($User->findByUsername($username) !== null) {
                        $errors[] = 'Le username est déjà utilisé';
                        exit();
                    }

                    if (empty($errors)) {
                        $res = $User->create($email, $username, $password, $profile_picture_url, $description);

                        $_SESSION["auth"] = true;
                        $_SESSION["username"] = $username;
                        $_SESSION["description"] = $description;
                        
                        $success[] = 'Votre compte à été crée. Connectez-vous !';
                        $_SESSION['success'] = $success;
                        header("Location: /");
                        exit();
                    }
            } else {
                $errors[] = 'Tous les champs sont obligatoires';
            }

            $_SESSION["errors"] = $errors;
            header("Location: /");
            exit();
            
        }

        public function logout() {
            session_destroy();
            header("Location: /");
            exit();
        }
    }
?>