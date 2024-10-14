<?php

require_once '../models/UserDAO.php';

class User {
    private $conn;
    private $dao;

    public $id;
    public $name;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
        $this->dao = new UserDAO($db);
    }

    
    public function create() {
        return $this->dao->create($this);
    }

   
    public function readOne($id) {
        return $this->dao->readOne($id);
    }

   
    public function login($name, $password) {
        return $this->dao->login($name, $password);
    }
}

?>

