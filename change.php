<?php
ob_start();
session_start();

if(isset($_GET['logout']))
{
    session_destroy();
     header("Location: login.php");
        exit();
}

 if( (!isset($_SESSION['userlogin'])) || (!isset($_SESSION['username'])) )

        {
             
        header("Location: login.php");
        exit();
        }



?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Favicons -->

<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Change Accounts!</title>
  </head>
  <body>
    <div style="margin-top:120px" class="container ">
  
        <div class="row">


        <div class="col-sm-12 col-md-8 offset-md-2">
    <?php
    if(isset($_SESSION['update_done'])){  ?>
   <div class="alert alert-success" role="alert">
<?php echo $_SESSION['ac']  ?> Token is updated!
</div>     
   <?php  unset($_SESSION['update_done']); }
   ?>
     <?php
    if(isset($_SESSION['update_noo'])){  ?>
   <div class="alert alert-danger" role="alert">
<?php echo $_SESSION['ac']  ?> Token Empty is not update, try again!
</div>     
   <?php  unset($_SESSION['update_noo']); }
   ?>
      <?php
    if(isset($_SESSION['update_error'])){  ?>
   <div class="alert alert-danger" role="alert">
<?php echo $_SESSION['ac']  ?> Token is not update, try again!
</div>     
   <?php  unset($_SESSION['update_error']); }
   ?>
    <?php
    if(isset($_SESSION['invalid'])){  ?>
   <div class="alert alert-danger" role="alert">please enter 1 token at a time
</div>     
   <?php  unset($_SESSION['invalid']); }
   ?>
            
            
                <div class="card mt-2">
                    <div class="card-body">
                                                <h3>Update Jasper Account  <span><a href="?logout" class="btn btn-primary">Logout</a></span></h3>
<hr>



<form action="updatee.php" method="post">
    
    
 <div class="mb-3">
      <label for="token1" class="form-label">Account 1 Token</label>
        <textarea class="form-control" id="token1" name="token" rows="3"placeholder="enter your 1 token"></textarea>
        <input type="hidden" name="acc" value="jasper1">
    </div>
 
  <button type=" " class="btn btn-primary">Update Account 1</button>
</form> <hr>

<form action="updatee.php" method="post">
    
    
 <div class="mb-3">
      <label for="token2" class="form-label">Account 2 Token</label>
        <textarea class="form-control" id="token1" name="token" rows="3"placeholder="enter your 2 token"></textarea>
        <input type="hidden" name="acc" value="jasper2">
    </div>
 
  <button type=" " class="btn btn-primary">Update Account 2</button>
</form> <hr>

<form action="updatee.php" method="post">
    
    
 <div class="mb-3">
      <label for="token3" class="form-label">Account 3 Token</label>
        <textarea class="form-control" id="token1" name="token" rows="3"placeholder="enter your 3 token"></textarea>
        <input type="hidden" name="acc" value="jasper3">
    </div>
 
  <button type=" " class="btn btn-primary">Update Account 3</button>
</form> <hr>

<form action="updatee.php" method="post">
    
    
 <div class="mb-3">
      <label for="token4" class="form-label">Account 4 Token</label>
        <textarea class="form-control" id="token1" name="token" rows="4"placeholder="enter your 4 token"></textarea>
        <input type="hidden" name="acc" value="jasper4">
    </div>
 
  <button type=" " class="btn btn-primary">Update Account 4</button>
</form> <hr>

<form action="updatee.php" method="post">
    
    
 <div class="mb-3">
      <label for="token4" class="form-label">Account 5 Token</label>
        <textarea class="form-control" id="token1" name="token" rows="4"placeholder="enter your 5 token"></textarea>
        <input type="hidden" name="acc" value="jasper5">
    </div>
 
  <button type=" " class="btn btn-primary">Update Account 5</button>
</form> <hr>

</div>
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