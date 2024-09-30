<?php
// app/controllers/AuthController.php
require_once '../config/database.php';
require_once '../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->user = new User($this->db);
    }

    public function register($name, $password, $role) {
        $this->user->name = $name;
        $this->user->password = $password;
        $this->user->role = $role;
        return $this->user->create();
    }

    public function login($name, $password) {
        return $this->user->login($name, $password);
    }
}
?>
