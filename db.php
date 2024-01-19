<?php

class Database {
    public $pdo;

    public function __construct($database = "kickbox", $user = "root", $pwd="", $host="localhost:3307") {
        try{
            $this->pdo = new PDO("mysql:host=$host;dbname=$database", $user, $pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function insertPlayers($a, $b, $c) {
        $sql = "INSERT INTO players VALUES (null, :naam, :achternaam, :leeftijd)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['naam' => $a, 'achternaam' => $b, 'leeftijd' => $c]);    
    }

    public function selectPlayers($id = null) {
        if($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM spelers WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $stmt = $this->pdo->query("SELECT * FROM spelers");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public function editUser($naam, $achternaam, $leeftijd, $id) {
        $stmt = $this->pdo->prepare("UPDATE spelers SET naam = ?, achternaam = ?, leeftijd = ? WHERE id = ?");
        $stmt->execute([$naam, $achternaam, $leeftijd, $id]);    
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM spelers WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function register($username, $password, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO accounts (gebruikersnaam, wachtwoord, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $email]);
    }

    public function login($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result;
    }
}
?>