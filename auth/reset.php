<?php 
 include "../config/db.php";
   if($_SERVER["REQUEST_METHOD"]!== "GET"){
    echo "Try again";
    exit;
   }
   if(!isset($_GET["token"])){
     echo "Try again";
     exit;
   }
   $token = $_GET["token"];
       
  //confirm token is from db
   $sql = "SELECT  expire FROM reset WHERE token =?";
   $stmt = $conn->prepare($sql);
   if (!$stmt) {
    echo  "DB query failed";
    exit;
   }
  
      if (!$stmt->execute([$token])) {
    echo "DB execution failed";
    exit;
  }
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$row){
    echo "Token does not exist";
    exit;
  }
  $expire = $row["expire"];
  if(strtotime($expire) < time()){
    echo "Token is expired";
    exit;
  }

  
     

   header("Location: ../update_pass.php?token=$token");
   exit;
?>