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
            $('#weight').maskMoney({precision:0});
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
        include('koneksi.php');
        $id=$_GET['id'];
        $query="SELECT * FROM card WHERE cardId='$id'";
        $hasil=querySelect($query);
        $name=$hasil['cardName'];
        $height=$hasil['cardHeight'];
        $width=$hasil['cardWidth'];
        $length=$hasil['cardLength'];
        $type=$hasil['cardType'];
        $weight=$hasil['cardWeight'];
        $price=$hasil['cardPrice'];
        $date=$hasil['cardAdded'];
        $photo=$hasil['cardPhoto'];
        
        if(isset($_POST['submit'])){
            //insert image
            if(!empty($_FILES["fileToUpload"]["tmp_name"])){
              $target_dir = "images/part/";
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
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
                $nphoto=basename($_FILES["fileToUpload"]["name"]);
            }

            $name=$_POST['name'];
            $type=$_POST['type'];
            $price=str_replace(",", "", $_POST['price']);
            $height=$_POST['height'];
            $width=$_POST['width'];
            $length=$_POST['length'];
            $weight=$_POST['weight'];
            $query="UPDATE card SET cardName='$name', cardHeight='$height', cardWidth='$width', cardLength='$length', cardType='$type', cardWeight='$weight', cardPrice='$price'";
            if(isset($nphoto)){
                $query.=", cardPhoto='$nphoto'";
            }
            $query.=" WHERE cardId='$id'";
            queryRun($query);
            header("location:mantype.php");
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
                <h1>Edit Car Model</h1>
                <form class="form-horizontal" id=newcar method=post enctype="multipart/form-data">
                    <h2>Specification</h2>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">Car Name:</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="<?php echo $name?>" required>
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
                            <script>$( "#type" ).val( "<?php echo $type?>" )</script>
                        </div>
                        <label class="control-label col-sm-3" for="price">Price:</label>
                        <div class="col-sm-3 input-group">
                            <span class="input-group-addon">Rp. </span>
                            <input required type="text" class="form-control" id="price" placeholder="Enter price (IDR)" name=price value="<?php echo $price?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="pic">Change Picture:</label>
                        <div class="col-sm-9">
                            <input type="file" name=fileToUpload id="fileToUpload" placeholder="Enter picture" value="<?php echo $photo?>">
                        </div>
                    </div>

                    <h2>Car Dimensions</h2>
                    <div class=form-group>
                        <div class="col-sm-6">
                            <label class="control-label col-sm-6" for="height">Height:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=height type=text class=form-control id=height placeholder="Insert car's height (m)" value="<?php echo $height?>" required>
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>

                        <div class=col-sm-6>
                            <label class="control-label col-sm-6" for="width">Width:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=width type=text class=form-control id=width placeholder="Insert car's width (m)" value="<?php echo $width?>" required>
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class=form-group>
                        <div class="col-sm-6">
                            <label class="control-label col-sm-6" for="length">Length:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=length type=text class=form-control id=length placeholder="Insert car's length (m)" value="<?php echo $length?>" required>
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label col-sm-6" for="weight">Weight:</label>
                            <div class="col-sm-6 input-group">
                                <input required name=weight type=text class=form-control id=weight placeholder="Insert car's weight (kg)" value="<?php echo $weight?>" required>
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button name=submit type="submit" class="btn btn-default" id=submit value=submit>Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <a href="mantype.php"><input required type="button" class="btn btn-default" value=Cancel></a>
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
