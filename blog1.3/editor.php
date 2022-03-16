<?php

require_once 'dbConnection.php';  // connect db & server

function Clean($input){  //clean user inputs

     $input = trim($input);
     $input = strip_tags($input);
     $input = stripslashes($input);

     return $input;
}

# Errors Array ... 
$errors = [];   

if ($_SERVER['REQUEST_METHOD'] == "POST") {

     $title     = Clean($_POST['title']);
     $content    = Clean($_POST['content']);
   
    # Validate Title ..... 
    if(empty($title)){
        $errors['Title'] = "<p class='Ralert'>Title Required</p>";
     }elseif(!preg_match("/^[a-zA-Z ]*$/", $title)){  #STRING VALIDATION PART (*.*)
          $errors['Title']  = "<p class='Ralert'>Only letters and white space allowed.</p>"; 
     }else{
          $_SESSION['Title'] = $title;
     }

    # Validate Content .... 
    if(empty($content)){
          $errors['Content']  = "<p class='Ralert'>Title Required</p>"; 
     }elseif(strlen($content) < 50){
          $errors['Content']  = "<p class='Ralert'>Adress Length Must Be >= 50 Chars</p>"; 
     }else{
          $_SESSION['Content'] = $content;
     }

     # Validate image ....
     if (!empty($_FILES['image']['name'])) {

          $imgName    = $_FILES['image']['name'];
          $imgTemName = $_FILES['image']['tmp_name'];
          $imgType    = $_FILES['image']['type'];
          $imgSize    = $_FILES['image']['size'];

          # Allowed Extensions 
          $allowedExtensions = ['jpg', 'png', 'jpeg'];

          $imgArray = explode('/', $imgType);

          # Image Extension ...... 
          $imageExtension = end($imgArray);


          if (in_array($imageExtension, $allowedExtensions)) {

          # IMage New Name ...... 
          $FinalName = time() . rand() . '.' . $imageExtension;

          $disPath = 'uploads/' . $FinalName;


          if (move_uploaded_file($imgTemName, $disPath)) {

          } else {
               $errors['Img']  = "<p class='Ralert'>Error try Again</p>";
          }
          } else {
               $errors['Img']  = "<p class='Ralert'>InValid Extension</p>";
          }
     } else {
          $errors['Img']  = "<p class='Ralert'>* Image Required</p>";
     }


   # Check Errors ...... 
   if(count($errors) > 0 ){
       echo '<p class="Ralert">Post Failed</p>';
   }else{

       $sql = "insert into articles (title,img,content) values ('$title','$FinalName','$content')";
       $op =  mysqli_query($con, $sql);

       if ($op) {
           echo '<p class="Gsuss">Posted Sucssesfully</p>';
       }

       mysqli_close($con);
   }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Article</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
         .Ralert{
              color: red;
         }
         .Gsuss{
              color: green;
         }
         textarea{
              height: 250px !important;
         }
     </style>
</head>

<body>

    <div class="container">
        <h3>Post New Article</h3>

        <form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputTitle">Title</label>
                <input type="text" class="form-control" id="exampleInputTitle" aria-describedby=""   name="title" placeholder="Enter Title">
                <?php if(isset($errors['Title'])) {echo $errors['Title'];} ?>
            </div>

            <div class="form-group">
                <label for="exampleContent">Content</label>
                <textarea type="text" class="form-control" id="exampleContent" aria-describedby=""   name="content" placeholder="Enter Content"></textarea>
                <?php if(isset($errors['Content'])) {echo $errors['Content'];} ?>
            </div>

            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <?php if(isset($errors['Img'])) {echo $errors['Img'];} ?>
                <input type="file" name="image">
            </div>
           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
