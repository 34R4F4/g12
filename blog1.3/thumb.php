<?php
require_once 'dbConnection.php';

# Fetch Id Data ...... 
$id = $_GET['id'];

$sql = "select * from articles where id = $id"; 
$op  = mysqli_query($con,$sql); 
# Fetch Data 
$data = mysqli_fetch_assoc($op);

$old = "uploads/".$data['img'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
     $errors = [];
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
               //echo 'Image Uploaded Succ ';
               //$v3 = 1;
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
       echo '<p class="Ralert">Process Failed</p>';
   }else{
          $sql = "update articles set img = '$FinalName' where id = $id";
          $op =  mysqli_query($con,$sql);
          if($op){
               echo '<p class="Gsuss">Photo Changed Sucssesfully</p>'.$old;
               
               unlink($old);
               header("Location: blog.php");
          }
          mysqli_close($con);
     }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Article</title>
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
        <h3>change photo</h3>

        <form action='thumb.php?id=<?php echo $data['id'];?>' method="post" enctype="multipart/form-data">

            <div class="form-group">
            <?php if(isset($data['img'])) {echo "<img src='uploads/".$data['img']."'>";} ?>
            </div>

            <div class="form-group">
                <label for="exampleInputName">New Image</label>
                <?php if(isset($errors['Img'])) {echo $errors['Img'];} ?>
                <input type="file" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>