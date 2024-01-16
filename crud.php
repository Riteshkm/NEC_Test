<?php
session_start();
require_once("db.php");
require_once("user.php");
require_once("user_file.php");

if (isset($_REQUEST['registerButton'])) {
  $fullName = $_POST["fullName"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $user = new User();
  $error = "";
  $existingUser = $user->isEmailExists($email);
  if ($existingUser) {
      $error = "Email already exists. Please choose a different email.";
  } else {
      $result = $user->createUser($fullName, $email, $password);
      if (!$result) {
          $error = "Error creating user. Please try again.";
      }
  }

  if (!empty($error)) {
      $_SESSION['error'] = $error;
      header("Location: register.php");
      exit();
  } else {
      $_SESSION['success'] = "Signup successful!";
      header("Location: index.php");
      exit();
  }
}

if (isset($_REQUEST['loginButton'])) {
  $loginEmail = $_POST["email"];
  $loginPassword = $_POST["password"];
  $user = new User();
  $loggedInUser = $user->loginUser($loginEmail, $loginPassword);
  if ($loggedInUser) {
      $_SESSION['user'] = $loggedInUser;
      header("Location: fileupload.php");
      exit();
  } else {
      $_SESSION['loginError'] = "Invalid email or password. Please try again.";
      header("Location: index.php");
      exit();
  }
}

if (isset($_FILES["file"])) {
  $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
  if ($user) {
      $targetDir = "uploads/";
      $targetFile = $targetDir . basename($_FILES["file"]["name"]);
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
          $fileUrl = $targetFile;
          $fileName = $_FILES["file"]["name"];
          $userId = $user['id'];
          $userfile = new UserFile();
          $uploafile = $userfile->uploadFile($userId, $fileName, $fileUrl);
          echo $uploafile;
      } else {
          echo "Error uploading file.";
      }
  } else {
      echo "User not authenticated.";
  }
} else {
  echo "No file selected.";
}