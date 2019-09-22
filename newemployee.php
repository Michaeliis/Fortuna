<?php
SESSION_START();
if(isset($_SESSION['empId']) AND $_SESSION['positionAccess'] <= 2){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>New Employee</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/css.css">
        <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
        <script src="js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      
        
        <script src="js/jquery.validate.js"></script>
        <script src="js/jquery.maskMoney.js"></script>
        <script>
            // just for the demos, avoids form submit
            $().ready(function() {
                $("#newemp").validate({
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
        <script>
          $(function() {
            $('#price').maskMoney({precision:0});
            $('#height').maskMoney({precision:0});
            $('#width').maskMoney({precision:0});
            $('#length').maskMoney({precision:0});
            $('#weight').maskMoney({precision:0});
          })
        </script>
        <style>
            #newemp label.error {
                color: red;
            }

            * {
                border-radius: 0 !important;
            }
            @media only screen and (max-width: 600px) {
              #mainnav{
                  display:none;
                }
            }
        </style>
  </head>
  <body>
    <?php include('koneksi.php');
    if(isset($_POST['submit'])){
        
        //insert image
        $target_dir = "images/user/";
        $target_file = $target_dir . basename($_FILES["pic"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
        
        
        $check = getimagesize($_FILES["pic"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["pic"]["size"] > 500000) {
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
            if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $empPhoto= basename( $_FILES["pic"]["name"]);
      $empFName=$_POST['fname'];
      $empLName=$_POST['lname'];
      $there=mysqli_query($con, "SELECT MAX(empId) AS 'there' FROM employee");
      $hello=mysqli_fetch_array($there);
      $empId="";
      if(!$hello['there']){
        $empId="000001";
      }else{
        $empId=sprintf("%06d", ($hello['there']+1));
      }
      $empDOB=$_POST['dob'];
      $empPhone=$_POST['phone'];
      $empMail=$_POST['mail'];
      $empAddress=$_POST['address'];
      $empPosition=$_POST['position'];
      $empPass=date_format(date_create($empDOB), "dmY");
        $dateLimit=date('Y-m-d', strtotime(date("Y-m-d"). '+ 1000 year'));
      global $con;
        $query=mysqli_prepare($con, "INSERT INTO employee VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
        mysqli_stmt_bind_param($query, "sssssssssss",  $empId, $empFName, $empLName, $empDOB, $empPass, $empPosition, $empMail, $empPhone, $empAddress, $empPhoto, $dateLimit);
        mysqli_stmt_execute($query);
    } ?>
    <nav id=mainnav class="navbar navbar-inverse" >
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
      <h1>New Employee</h1>
      <form id=newemp class="form-horizontal" action="" method=post enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-sm-3" for="fname">First Name:</label>
          <div class="col-sm-9">
            <input name=fname type="text" class="form-control" id="fname" placeholder="Enter First name" important>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="lname">Last Name:</label>
          <div class="col-sm-9">
            <input name=lname type="text" class="form-control" id="lname" placeholder="Enter Last name" important>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="dob">Date of Birth:</label>
          <div class="col-sm-3">
            <input name=dob type="date" class="form-control" id="dob">
          </div>
          <label class="control-label col-sm-3" for="photo">Photo:</label>
          <div class="col-sm-3">
            <input name=pic type="file" class="form-control" id="pic" placeholder="Insert photo"important>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="phone">Phone number:</label>
          <div class="col-sm-3">
            <input name=phone type="tel" class="form-control" id="phone" important>
          </div>
          <label class="control-label col-sm-3" for="mail">Email:</label>
          <div class="col-sm-3">
            <input name=mail type="email" class="form-control" id="mail" placeholder="Insert email" important>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="position">Position:</label>
          <div class="col-sm-3">
            <select name=position id=position>
              <option value="Admin">Admin</option>
              <option value="Manager">Manager</option>
              <option value="Employee">Employee</option>
              <option value="courier">Courier</option>
            </select>
          </div>
          <label class="control-label col-sm-3" for="address">Address:</label>
          <div class="col-sm-3">
            <textarea name=address id=address row=3 cols="30"></textarea>
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
