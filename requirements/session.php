<?php
require_once("config.php"); 

@session_start();
@ob_start();
$user_id = @$_SESSION['user_id'];

if(!isset($user_id)){
   if(isset($_COOKIE['remember'])){
       
      $users=$db->prepare("SELECT * FROM users where token=:token");
      $users->execute(array(
      'token'=>$_COOKIE['remember']
      ));
      $remembercek=$users->fetch(PDO::FETCH_ASSOC);
      
         $mail = @$remembercek['email'];
         $pass = @$remembercek['password'];
      
         $select = $db->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select->execute([$mail, $pass]);
         $row = $select->fetch(PDO::FETCH_ASSOC);
      
         if($select->rowCount() > 0){
      
              $_SESSION['user_id'] = $row['id'];
              header("location:$url/");
      
           }else{
               $message[] = 'no user found!';
            }
            
         }else{
            $message[] = 'incorrect mail or password!';
         }
   }



$select_profile = $db->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if(!isset($fetch_profile["id"])){
   header("Location:$url/login.php");
   exit;
}

?>