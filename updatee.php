<?php
ob_start();
session_start();
 if( (!isset($_SESSION['userlogin'])) || (!isset($_SESSION['username'])) )

        {
             
        header("Location: login.php");
        exit();
        }


include "db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
       date_default_timezone_set("Asia/Calcutta");
     

    $date = date('m/d/Y h:i:s a', time());
    
    
    $token = test_input($_POST['token']);
     $account = test_input($_POST['acc']);
  
        if(empty($token)){
            
              $_SESSION['update_noo'] =   true;
             
       $_SESSION['ac'] =   $account;
    
echo $error = mysqli_error($connect);
      header("Location: login.php");
        }   else {    $sql = "UPDATE  cookie_arafat SET cookie='$token', last_update='$date'  WHERE name='$account' ";
 
        }
    $res = mysqli_query($connect, $sql);
   
    
    if($res)
    {
      $_SESSION['update_done'] =   true;
       $_SESSION['ac'] =   $account;
      
      echo $error = mysqli_error($connect);
     header("Location: change.php");
    } else{
      $_SESSION['update_error'] =   true;
      $_SESSION['ac'] =   $account;
echo $error = mysqli_error($connect);
      header("Location: login.php");
    }
    
}