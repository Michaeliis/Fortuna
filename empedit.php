<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Employee Edit</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    //insert image
    $id=$_GET['id'];
    $query="SELECT * FROM employee WHERE empId='$id' AND empStatus=1";
    $hasil=querySelect($query);
    $fname=$hasil['empFName'];
    $lname=$hasil['empLName'];
    $posi=$hasil['empPosition'];
    $mail=$hasil['empMail'];
    $phone=$hasil['empPhone'];
    $address=$hasil['empAddress'];
    $DOB=$hasil['empDOB'];
    if(isset($_POST['submit'])){
        if(!empty($_FILES["fileToUpload"]["tmp_name"])){
          $target_dir = "images/user/";
          $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 1;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            $nphoto=basename($_FILES["fileToUpload"]["name"]);
        }
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $dob=$_POST['dob'];
        $phone=$_POST['phone'];
        $pos=$_POST['position'];
        $mail=$_POST['mail'];
        $address=$_POST['address'];
        $query="UPDATE employee SET empFName='$fname', empLName='$lname', empPosition='$pos', empMail='$mail', empPhone='$phone', empAddress='$address', empDOB='$DOB'";
        if(isset($nphoto)){
            $query.=", empPhoto='$nphoto'";
        }
        $query.=" WHERE empId=$id";
        if(isset($nphoto)){
            if($uploadOk==1){
                queryRun($query);
            }
        }else{
            queryRun($query);
        }
    }
    ?>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">FORTUNA</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="newpurchase.php">New Purchase</a></li>
            <li><a href="newmanufactur.php">New Manufacture</a></li>
            <li><a href="newdelivery.php">New Delivery</a></li>
            <?php
              if($_SESSION['positionAccess'] <= 2){
                ?>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"href="#">Manage<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="manparts.php">Spare Parts</a></li>
              <li><a href="manemployee.php">Employee</a></li>
              <li><a href="mancars.php">Cars</a></li>
              <li><a href="mantype.php">Car Model</a></li>
              <li><a href="mansupp.php">Suppliers</a></li>
              <li><a href="mancust.php">Customer</a></li>
            </ul>
          </li>
            <?php
              }
            ?>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"href="#">Report<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="hispurchase.php">Purchase Report</a></li>
              <li><a href="hismanufacture.php">Manufacture Report</a></li>
              <li><a href="mandel.php">Delivery Report</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name']?></a> </li>
          <li><a href="login.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
      </ul>
      </div>
    </nav>

    <!--Body-->
    <div class="container">
      <h1>Edit Employee</h1>
        
      <form class="form-horizontal" action="" method=post  enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-sm-3" for="fname">First Name:</label>
          <div class="col-sm-9">
            <input name=fname type="text" class="form-control" id="fname" placeholder="Enter First name" value="<?php echo $fname?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="lname">Last Name:</label>
          <div class="col-sm-9">
            <input name=lname type="text" class="form-control" id="lname" placeholder="Enter Last name" value="<?php echo $lname?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="dob">Date of Birth:</label>
          <div class="col-sm-3">
            <input name=dob type="date" class="form-control" id="dob" value="<?php echo $DOB?>" required>
          </div>
          <label class="control-label col-sm-3" for="photo">Change Photo:</label>
          <div class="col-sm-3">
            <input id="fileToUpload" name=fileToUpload type="file" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="phone">Phone number:</label>
          <div class="col-sm-3">
            <input name=phone type="text" class="form-control" id="phone" value="<?php echo $phone?>" required>
          </div>
          <label class="control-label col-sm-3" for="mail">Email:</label>
          <div class="col-sm-3">
            <input name=mail type="text" class="form-control" id="mail" placeholder="Insert email" value="<?php echo $mail?>" required>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="position">Position:</label>
          <div class="col-sm-3">
            <select name=position id=position <?php if($posi=='Trial' && $_SESSION['empId']==$id){echo "disabled";}?> required>
                <option value="Trial">Trial</option>
              <option value="Admin">Admin</option>
              <option value="Manager">Manager</option>
              <option value="Employee">Employee</option>
            </select>
              <script>$( "#position" ).val( "<?php echo $posi?>" )</script>
          </div>
          <label class="control-label col-sm-3" for="address">Address:</label>
          <div class="col-sm-3">
            <textarea name=address id=address row=3 required><?php echo $address?></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" name=submit id=submit class="btn btn-default">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <a href="manemployee.php"><input type="button" class="btn btn-default" value=Cancel></a>
          </div>
        </div>
      </form>
    </div>

  </body>
  </html>

<?php
}else{
header("location:login.php?lfail=1");
} ?>
