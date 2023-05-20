<?php
ob_start();
session_start();
include "db.php";



    if((isset($_SESSION['userlogin'])) || (isset($_SESSION['username'])) )

        {
             
        header("Location: change.php");
        exit();
        }


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = test_input($_POST['username']);
      $password = test_input($_POST['password']);
    

    
    $sql = "SELECT * from admin_arafat WHERE username='$username' AND password='$password'";
    $res = mysqli_query($connect, $sql);
    $num = mysqli_num_rows($res);
    
    if($num ==1)
    {
      $_SESSION['username'] =   $username;
       $_SESSION['userlogin'] =   true;
        header("Location: change.php");
    
    } else {
         $_SESSION['username_error'] =   true;
    
   header("Location: login.php");
    }
    
}
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login!</title>
  </head>
  <body>
    <div style="margin-top:120px" class="container ">
  
        <div class="row">

  
      
    

                        <div class="col-sm-12 col-md-8 offset-md-2">
                <div class="card mt-2">
                    <div class="card-body">
                        
                                            <h3>Login to start your session </h3>  <?php
    if(isset($_SESSION['username_error'])){  ?>
   <div class="alert alert-danger" role="alert">
password wrong, please try again! 
</div>     
   <?php  unset($_SESSION['username_error']); }
   ?>
        
<hr>
<form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>" method="post">
  <div class="mb-3">
    <input type="text"  name="username"  class="form-control" id="username" placeholder="enter your username">
  </div>
   <div class="mb-3">
    <input type="text" name="password" class="form-control" id="password" placeholder="enter your password">
  </div>
 
  <button type="submit" class="btn btn-primary">Login</button>
</form>                   </div>
                </div>
            </div>
                    </div>
                    
                    
                    
                   
        <hr>
        <footer>
            <p class="mb-0">
                Copyright &copy; 2022, Maneged by Noobjoker
            </p>
        </footer>
    </div>
 
 
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   
   
  </body>
</html>