<?php
   include "../config/dbjson.php";
   require "../functions/confirmMail.php"; // the send mail function is in here 
   header("Content-Type: application/json");

   if($_SERVER["REQUEST_METHOD"] !== "POST"){
    echo json_encode(["success"=> false, "message"=> "Go register properly"]);
    exit;
   }

  // INFO FROM JS 
   $email = $_POST["email"];
   $name = $_POST["name"];
   $password = $_POST["password"];
   $hashedPass = password_hash($password, PASSWORD_DEFAULT);

   $token = bin2hex(random_bytes(32));
   $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));
     
$resetLink = "https://anonymous.pxxl.click/registerval.php?token=$token";
   // if you testing locally
  // $resetLink = "http://localhost/anonymous/registerval.php?token=$token";
   
if(empty($name)){
    echo json_encode(["success"=> false, "message"=> "Name cannot be empty"]);
    exit;
    }
    if(strlen($password)<8){
    echo json_encode(["success"=> false, "message"=> "Password cannot be less than 8 characters"]);
    exit;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
   echo json_encode(["success"=> false, "message"=> "input correct email format"]);
   exit;
    }

    // check if name is unique
    $nameSql = "SELECT id FROM users WHERE name = ?";
     $namestmt = $conn->prepare($nameSql);
     if(!$namestmt){
    echo json_encode(["success"=> false, "message" => "Failed"]);
        exit;
     }
     if(!$namestmt->execute([$name])){
       echo json_encode(["success"=> false, "message" => "failed"]);
        exit;
     }
     $nameSearchResults = $namestmt->fetchAll();
     if(count($nameSearchResults)>0){
            echo json_encode(["success"=> false, "message" => "Username is not available"]);
            exit;
     }

     // check if email has been used before
     $sql1 = "SELECT id FROM users WHERE email = ?";
     $stmt1 = $conn->prepare($sql1);
     if(!$stmt1){
    echo json_encode(["success"=> false, "message" => "Failed"]);
        exit;
     }
     if(!$stmt1->execute([$email])){
       echo json_encode(["success"=> false, "message" => "failed"]);
        exit;
     }
     $results = $stmt1->fetchAll();
     if(count($results)>0){
            echo json_encode(["success"=> false, "message" => "Email has been registered already, Log in"]);
            exit;
     }
     
   // write a function to update token and expire in pending_user table if email exists in table
   function updateToken ($conn, $token, $email, $expire, $resetLink){
    $UpdateToken_sql = "UPDATE pending_user SET token =?, expires_at =?  WHERE email = ? ";
    $prepareUpdateToken = $conn->prepare($UpdateToken_sql);
     if(!$prepareUpdateToken){
    return false;
    
   }
   if(!$prepareUpdateToken->execute([ $token,$expire, $email])){
    return false;
    
   }

  return  sendMail($email, $token, $resetLink);
   
   }

     // check if email exists in pending_user table
     $sql2 = "SELECT * from pending_user where  lower(email) = lower(?)";
     $stmt2 = $conn->prepare($sql2);
     if(!$stmt2){
    echo json_encode(["success"=> false, "message"=> "db failed "]);
    exit;
   }
   if(!$stmt2->execute( [$email])){
    echo json_encode(["success"=> false, "message"=> "insertion failed"]);
    exit;
   }
   $info = $stmt2->fetch();
   // if email exists already, update token and resend link
   if($info){
    if(updateToken($conn, $token, $email, $expire, $resetLink)){
        echo json_encode([
            "success"=> true,
            "message"=> "Email resent successfully"
        ]);
    } else {
        echo json_encode([
            "success"=> false,
            "message"=> "Failed to resend email"
        ]);
    }
    exit;
}
    
   // finally insert into pending user table if all other conditions are met
   $sql = "INSERT INTO pending_user(name, email, password, token, expires_at) VALUES (?,?,?,?,?)";
   $stmt = $conn->prepare($sql);
   if(!$stmt){
    echo json_encode(["success"=> false, "message"=> "db failed "]);
    exit;
   }
   if(!$stmt->execute([$name, $email, $hashedPass, $token, $expire])){
    echo json_encode(["success"=> false, "message"=> "insertion failed"]);
    exit;
   }
   
  if( sendMail($email, $token, $resetLink)){
echo json_encode(["success"=> true, "message"=> "Email has been sent successfully"]);

  }else{
   echo json_encode(["success"=> false, "message"=> "Email has not been sent successfully"]);
  }
   $conn = null; 
   exit;

   

?>