<?php

class User extends Database {
  public function createUser($fullName, $email, $password) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $currentdate = date('Y-m-d H:i:s');
      try {
          $stmt = $this->conn->prepare("INSERT INTO users (name, email, password,created_at) VALUES (?, ?, ?,?)");
          $stmt->execute([$fullName, $email, $hashedPassword,$currentdate]);

          return $stmt->rowCount();
      } catch (PDOException $e) {
          die("Error creating user: " . $e->getMessage());
      }
  }

  public function isEmailExists($email) {
      try {
          $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
          $stmt->execute([$email]);

          return $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          die("Error checking email existence: " . $e->getMessage());
      }
  }

  public function loginUser($email, $password) {
    try {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Error during login: " . $e->getMessage());
    }
  }
}