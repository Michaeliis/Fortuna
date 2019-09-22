<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Car Type Edit</title>

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
                $("#newcar").validate({
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
          })
        </script>

        <style>
            #newcar label.error {
                color: red;
            }

            * {
                border-radius: 0 !important;
            }

        </style>
    </head>

    <body>
        <?php
    include_once('koneksi.php');
    
    $id=$_GET['id'];
    $hasil= querySelect("SELECT * FROM card WHERE cardId='$id'");
    function newCar(){
      global $con;
      $target_dir = "images/car";
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
            if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $carPicture= basename( $_FILES["pic"]["name"]);
      $there=mysqli_query($con, "SELECT MAX(cardId) AS 'there' FROM card");
      $hello=mysqli_fetch_array($there);
      $carId="";
      $carName=$_POST['name'];
      $carSize=str_replace(",", "", $_POST['height'])."x".str_replace(",", "", $_POST['width'])."x".str_replace(",", "", $_POST['length']);
      $carType=$_POST['type'];
      $carWeight=$_POST['weight'];
      $carPrice=$_POST['price'];
      $carAdded=date("Y-m-d");
      
      $query="INSERT INTO card VALUES('$carId', '$carName', '$carSize', '$carType', $carWeight, $carPrice, '$carAdded', '$carPicture', 1)";
      queryRun($query);
    }
    if(isset($_POST['submit'])){
      newCar();
    } ?>
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
                <h1>New Car Model</h1>
                <form class="form-horizontal" id=newcar method=post>
                    <h2>Specification</h2>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">Car Name:</label>
                        <div class="col-sm-9 input-group">
                            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="type">Type:</label>
                        <div class="col-sm-3">
                            <select name=type id=type class=form-control>
                              <option value="">Select Car Type</option>
                              <option value=Sport>Sport</option>
                              <option value=Family>Family</option>
                              <option value=Minibus>Minibus</option>
                            </select>
                        </div>
                        <label class="control-label col-sm-3" for="price">Price:</label>
                        <div class="col-sm-3 input-group">
                            <span class="input-group-addon">Rp. </span>
                            <input required type="text" class="form-control" id="price" placeholder="Enter price (IDR)" name=price>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="pic">Picture:</label>
                        <div class="col-sm-9">
                            <input required type="file" name=pic id="pic" placeholder="Enter picture">
                        </div>
                    </div>

                    <h2>Car Dimensions</h2>
                    <div class=form-group>
                        <div class="col-sm-6">
                            <label class="control-label col-sm-6" for="height">Height:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=height type=text class=form-control id=height placeholder="Insert car's height (m)">
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>

                        <div class=col-sm-6>
                            <label class="control-label col-sm-6" for="width">Width:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=width type=text class=form-control id=width placeholder="Insert car's width (m)">
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class=form-group>
                        <div class="col-sm-6">
                            <label class="control-label col-sm-6" for="length">Length:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=length type=text class=form-control id=length placeholder="Insert car's length (m)">
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label col-sm-6" for="weight">Weight:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=weight type=text class=form-control id=weight placeholder="Insert car's weight (kg)">
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                    </div>

                    <h2>Car Parts</h2>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="tire">Tire:</label>
                        <div class="col-sm-3">
                            <select name=tire id=tire class=form-control>
                              <option value="">Select Car Tire</option>
                              <?php
                               ?>
                            </select>
                        </div>
                        <label class="control-label col-sm-3" for="price">Bolt:</label>
                        <div class="col-sm-3">
                            <input required name=bolt type="text" class="form-control" id="bolt" placeholder="Insert the amount of bolt">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button name=submit type="submit" class="btn btn-default" id=submit value=submit>Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <a href="mancars.php"><input required type="button" class="btn btn-default" value=Cancel></a>
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
