<?php

require 'dbConnection.php';

$sql = "select * from articles ";

$data = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Article</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
         .card {
          box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
          }

          .card {
          margin-top: 10px;
          box-sizing: border-box;
          border-radius: 2px;
          background-clip: padding-box;
          }
          .card span.card-title {
          color: #000;
          font-size: 24px;
          font-weight: 300;
          text-transform: uppercase;
          }

          .card .card-image {
          position: relative;
          overflow: hidden;
          }
          .card .card-image img {
          border-radius: 2px 2px 0 0;
          background-clip: padding-box;
          position: relative;
          z-index: -1;
          }
          .card .card-image span.card-title {
          padding: 16px;
          }
          .card .card-content {
          padding: 16px;
          border-radius: 0 0 2px 2px;
          background-clip: padding-box;
          box-sizing: border-box;
          }
          .card .card-content p {
          margin: 0;
          color: inherit;
          }
          .card .card-content span.card-title {
          line-height: 48px;
          }
          .card .card-action {
          border-top: 1px solid rgba(160, 160, 160, 0.2);
          padding: 16px;
          }
          .card .card-action a {
          color: white;
          margin-right: 10px;
          transition: color 0.3s ease;
          background-color: gray;
          padding: 10px;
          border-radius: 5px;
          }
          .card .card-action a:hover {
          color: #000;
          text-decoration: none;
          }
     </style>
</head>

<body>
<div class="container">
    <div class="row">
          <h1> Arafa Blog </h1>
    </div>
</div>
               <?php
                while ($raw = mysqli_fetch_assoc($data)) {
                ?> 
<div class="container">
    <div class="row">
        <!-- Card Projects -->
        <div class="col-md-6 col-md-offset-3">
            <div class="card">
                <div class="card-image">
                <span class="card-title"><?php echo $raw['title']; ?></span>
                    <img class="img-responsive" src="<?php echo 'uploads/'.$raw['img']; ?>">
                </div>
                


                <div class="card-content">
                    <p><?php echo $raw['content']; ?></p>
                </div>
                
                <div class="card-action">
                    <a href='edit.php?id=<?php echo $raw['id']; ?>' target="new_blank">Edit Article</a>
                    <a href='thumb.php?id=<?php echo $raw['id']; ?>' target="new_blank">Change Photo</a>
                    <a href='delete.php?id=<?php echo $raw['id']; ?>' target="new_blank">Delete Article</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }
mysqli_close($con);
?>

</body>
</html>