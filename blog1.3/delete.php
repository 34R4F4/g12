<?php 
  
  require 'dbConnection.php';

  $id = $_GET['id'];

# Fetch User Data .... 
 $sql = "select img from articles where id = $id"; 
 $op = mysqli_query($con,$sql); 
 $data = mysqli_fetch_assoc($op); 


  $sql = "delete from articles where id = $id "; 
  $op = mysqli_query($con,$sql); 
  if($op){ 
    unlink('uploads/'.$data['img']); 
      echo  'Article Removed';
      header("Location: blog.php");
  }else{
      echo  'Error Try Again';
  }

?>