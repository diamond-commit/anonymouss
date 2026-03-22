<?php 

  include "../config/db.php";
   $token = $_GET["token"] ?? null;

  if(!$token){
   echo "no valid token ";
   exit;
  }
  
   $getTokenInfo = "SELECT * from pending_user where token =? ";
    $preparesql = $conn->prepare($getTokenInfo);

    if(!$preparesql){
      echo "something went wrong, Try again";
    }
  if (!$preparesql->execute([$token])) {
    echo "DB execution failed";
    exit;
  }
  $row = $preparesql->fetch(PDO::FETCH_ASSOC);
  if(!$row){
    echo "Token does not exist";
    exit;
  }
  $expire = $row["expires_at"];
  if(strtotime($expire) < time()){
    echo "Token is expired";
    exit;
  }
  $name = $row["name"];
  $email = $row["email"];
  $hashedPassword = $row["password"];

     $sql = "INSERT INTO users(name, email, password) VALUES (?,?,?)";
     $stmt = $conn->prepare($sql);
     if(!$stmt){
    echo  "Failed";
        exit;
     }
     if(!$stmt->execute([ $name, $email, $hashedPassword])){
       echo "failed";
        exit;
     }
     $delete =  $conn->prepare("delete from pending_user where token =?");
     $delete->execute([$token]);
        header("Location: ../login.php");
     $conn = null;
?>