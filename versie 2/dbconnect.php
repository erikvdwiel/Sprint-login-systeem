<?php

class User
{
    public string $username;
    public string $password;

    public function __construct() {
        // Construct the user object here
    }

    public function LogIn(PDO $database, string $username, string $password) {
        // Check the data with the database
        $sql = "SELECT * FROM user WHERE username = :username;";
        $stmt = $database->prepare($sql);
        $stmt->execute(array(":username" => $username));
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$res || password_verify($password, $res['password'])) {
            $this->username = $username;
            $this->password = $password;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION["user"] = $this;
            return $res;
        }
    }

    public function Register(PDO $database, string $username, string $password) {
        // insert the data into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (username, password) VALUES (:username, :password);";
        $stmt = $database->prepare($sql);
        return $stmt->execute(array(":username" => $username, ":password" => $hashedPassword));
    }

    public function LogOut() {
        unset($this->username);
        unset($this->password);
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION["user"]);
    }
}

?>