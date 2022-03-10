<?php

   function Clean($input){
     
       $input = trim($input);
       $input = strip_tags($input);
       $input = stripslashes($input);

       return $input;
   //     return  stripslashes(strip_tags(trim($input)));
   }



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name     = Clean($_POST['name']);
    $email    = Clean($_POST['email']);
    $password = $_POST['password'];
    $adress     = Clean($_POST['adress']);
    $gender     = $_POST['gender'];
    $linkedin     = $_POST['linkedin'];
   
    # Errors Array ... 
    $errors = []; 
    
    # Validate Name ..... 
    if(empty($name)){
        $errors['Name'] = "Required Field ";
    }/* else{
         //$alpha = ['a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'];
         //$mName = explode('',$name);
    } */

    # Validate Email ... 
    if(empty($email)){
        $errors['Email']  = "Required Field"; 
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['Email']  = "Invalid Format"; 
    }
    

    # Validate Password .... 
    if(empty($password)){
        $errors['Password']  = "Required Field"; 
    }elseif(strlen($password) < 6){
        $errors['Password']  = "Password Length Must Be >= 6 Chars"; 
    }

    # Validate Adress .... 
    if(empty($adress)){
          $errors['adress']  = "Required Field"; 
     }elseif(strlen($adress) < 10){
          $errors['adress']  = "Adress Length Must Be >= 10 Chars"; 
     }

    # Validate Gender .... 
    if(empty($gender)){
          $errors['gender']  = "<p class='Ralert'>Not Valide Gender Choose</p>"; 
     }elseif($gender = 'male' or $gender = 'female'){
          echo '<p class="Gsuss">Valide Gender Choose</p>';
     }

    # Validate linkedin ... 
    if(empty($linkedin)){
          $errors['linkedin']  = "Required Field"; 
     }elseif(!filter_var($linkedin,FILTER_VALIDATE_URL)){
          $errors['linkedin']  = "Invalid Format"; 
     }

   # Check Errors ...... 
   if(count($errors) > 0 ){
       foreach ($errors as $key => $value) {
           # code...
           echo '* '.$key.' : '.$value.'<br>';
       }
   }else{
       echo '<p class="Gsuss">data registered Sucssesfully</p>';
   }


}

?>
<?php



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // CODE ..... 

    if (!empty($_FILES['pdf']['name'])) {

        $imgName    = $_FILES['pdf']['name'];
        $imgTemName = $_FILES['pdf']['tmp_name'];
        $imgType    = $_FILES['pdf']['type'];
        $imgSize    = $_FILES['pdf']['size'];

        # Allowed Extensions 
        $allowedExtensions = ['pdf'];

        $imgArray = explode('/', $imgType);

        # pdf Extension ...... 
        $pdfExtension = end($imgArray);


        if (in_array($pdfExtension, $allowedExtensions)) {

            # pdf New Name ...... 
            $FinalName = time() . rand() . '.' . $pdfExtension;

            $disPath = 'uploads/' . $FinalName;


            if (move_uploaded_file($imgTemName, $disPath)) {
                echo 'pdf Uploaded Succ ';
            } else {
                echo 'Error try Again';
            }
        } else {
            echo 'InValid Extension .... ';
        }
    } else {
        echo '<p class="Gsuss">* pdf Required</p>';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
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
     </style>
</head>

<body>

    <div class="container">
        <h3>Register</h3>

        <form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" id="exampleInputName" aria-describedby=""   name="name" placeholder="Enter Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">New Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
            </div>

            <div class="form-group">
                <label for="exampleAdressName">Adress</label>
                <input type="text" class="form-control" id="exampleAdressName" aria-describedby=""   name="adress" placeholder="Enter Adress">
            </div>

            <div class="form-group">
                <label for="exampleGenderName">Gender</label>
                <select class="form-control" id="exampleGenderName" aria-describedby=""   name="gender">
                <option value="">--- Choose Gender ---</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div> 

            <div class="form-group">
                <label for="exampleLinkedURL">Adress</label>
                <input type="text" class="form-control" id="exampleLinkedURL" aria-describedby=""   name="linkedin" placeholder="Enter LinkedIn URL">
            </div>  

            <div class="form-group">
                <label for="exampleInputName">Upload Your CV</label>
                <input type="file" name="pdf">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
