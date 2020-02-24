<?php

require_once('Parser.class.php');
require_once('Analyzer.class.php');


    if(isset($_POST['submit']))
{
    $file_name = "first.csv";
    save_file($_FILES['sender']['tmp_name'], $file_name);
    $csvParser = new Parser();
    $parsedFile = $csvParser->parse($file_name);
    
}


function save_file($file, $file_name)
{
    move_uploaded_file($file, "files/" . $file_name);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link href="styles/main.css" rel="stylesheet">
</head>
<body>
<?php if(!isset($_POST['submit'])) : ?>
<div class="border border-primary location_center ">

<form method="post" enctype="multipart/form-data" action="" class="md-form">
  <div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Choose file</span>
      <input type="file" name="sender">
    </div>
    <div class="file-path-wrapper">
      <button class="btn btn-primary" type="submit" name="submit">Send me</button>
    </div>
  </div>
</form>
</div>
<?php endif ?>
<?php if(isset($_POST['submit'])) : ?>
    <table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Total Calls</th>
      <th scope="col">Total Time</th>
      
    </tr>
  </thead>
  <tbody>
  <?php foreach($parsedFile as $row ) : ?>
    <tr>
   
     
       <td><?=$row['id'];?></td>
       <td><?=$row['total_calls'];?></td>
       <td><?=$row['total_time'];?></td>
    </tr>
    <?php endforeach ?>
  </tbody>

</table>
<?php endif ?>






    
</body>
</html>