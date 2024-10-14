<?php


class UserDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function create(User $user) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");

        
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);

        
        return $stmt->execute([$user->name, $hashedPassword, $user->role]);
    }

    
    public function readOne($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

  
    public function login($name, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name = ?");
        $stmt->execute([$name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       
        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }

        return false; 
    }
}
?>
