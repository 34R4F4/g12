<?php
require_once 'dbConnection.php';

# Fetch Id Data ...... 
$id = $_GET['id'];

$sql = "select * from articles where id = $id"; 
$op  = mysqli_query($con,$sql); 
# Fetch Data 
$data = mysqli_fetch_assoc($op);



function Clean($input){
 
    return  stripslashes(strip_tags(trim($input)));
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $title     = Clean($_POST['title']);
    $content    = Clean($_POST['content']);

    $errors = []; 
  
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

    
   # Check Errors ...... 
   if(count($errors) > 0 ){
    echo '<p class="Ralert">Post Failed</p>';
}else{
   
    $sql = "update articles set title = '$title' , content = '$content' where id = $id";
    $op =  mysqli_query($con,$sql);

  if($op){
    echo '<p class="Gsuss">Post Edited Sucssesfully</p>';
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
        <h3>Edit Article</h3>

        <form action="edit.php?id=<?php echo $data['id'];?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputTitle">Title</label>
                <input type="text" class="form-control" id="exampleInputTitle" aria-describedby=""  value="<?php echo $data['title'];?>" name="title" placeholder="Enter Title">
                <?php if(isset($errors['Title'])) {echo $errors['Title'];} ?>
            </div>

            <div class="form-group">
                <label for="exampleContent">Content</label>
                <textarea type="text" class="form-control" id="exampleContent" aria-describedby=""   name="content" placeholder="Enter Content"><?php echo $data['content'];?></textarea>
                <?php if(isset($errors['Content'])) {echo $errors['Content'];} ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>