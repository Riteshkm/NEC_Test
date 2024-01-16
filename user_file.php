<?php 
class UserFile extends Database {
  public function uploadFile($userId, $fileName, $fileUrl){
    try {
      $currentdate = date('Y-m-d H:i:s');
      $stmt = $this->conn->prepare("INSERT INTO user_files (user_id, file_name, file_url, created_at) VALUES (?, ?, ?,?)");
      $stmt->execute([$userId, $fileName, $fileUrl,$currentdate]);
      echo "File uploaded successfully!";
    } catch (PDOException $e) {
       die("Error storing file in the database: " . $e->getMessage());
    }
  }
}
?>