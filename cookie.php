<?php
session_start();


include "db.php";



$table  = "cookie_arafat";
//ek table mein 1 hi tools ho bas
$sql_get ="SELECT * FROM $table   WHERE name='$tool_name'";
$get_res = mysqli_query($connect,$sql_get);
while($tool1 = mysqli_fetch_assoc($get_res)){
   
    $cookiedb = $tool1['cookie'];
   
 }
 
 
 echo $erro = mysqli_error($connect);

 
