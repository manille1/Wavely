<?php
    class Database {
        private $pdo;

        public function __construct($config) {
            try {
                $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=' . $config['charset'];
                $this->pdo = new PDO($dsn, $config['user'], $config['password']);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }

        public function getPDO() {
            return $this->pdo;
        }
    }
?>