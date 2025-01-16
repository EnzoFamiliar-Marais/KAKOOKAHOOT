<?php
namespace Classes\Form;

use PDO;
use PDOException;

class Database {
    private $pdo;

    public function __construct($dbPath) {
        try {
            $this->pdo = new PDO("sqlite:" . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->initializeDatabase();
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    private function initializeDatabase() {
        $sql = "CREATE TABLE IF NOT EXISTS scores (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    score INTEGER NOT NULL,
                    date TEXT NOT NULL
                )";
        $this->pdo->exec($sql);
    }

    public function saveScore($name, $score) {
        $sql = "INSERT INTO scores (name, score, date) VALUES (:name, :score, :date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':score' => $score,
            ':date' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getScores() {
        $sql = "SELECT * FROM scores ORDER BY score DESC, date DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
