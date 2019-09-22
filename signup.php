
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Sign Up</title>

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
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    if(isset($_POST['submit'])){
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
        //insert image
        $target_dir = "images/user";
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
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $empPhoto= basename( $_FILES["pic"]["name"]);
      $empDOB=$_POST['dob'];
      $empPhone=$_POST['phone'];
      $empMail=$_POST['mail'];
      $empAddress=$_POST['address'];
      $empPosition="Trial";
      $empPass=date_format(date_create($empDOB), "dmY");
      $dateLimit=date('Y-m-d', strtotime(date("Y-m-d"). ' + 30 day'));
        global $con;
        $query=mysqli_prepare($con, "INSERT INTO employee VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
        mysqli_stmt_bind_param($query, "sssssssssss",  $empId, $empFName, $empLName, $empDOB, $empPass, $empPosition, $empMail, $empPhone, $empAddress, $empPhoto, $dateLimit);
        mysqli_stmt_execute($query);
        ?>
        <script>alert("Username: <?php echo $empId?>\nPassword: <?php echo $empPass?>")</script>
        <?php
    }
      
      ?>

    <!--Body-->
    <div class="container">
      <h1>Sign Up</h1>
      <form class="form-horizontal" action="" method=post enctype="multipart/form-data">
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
            <input name=pic type="file" class="form-control" id="pic" important>
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
          <label class="control-label col-sm-3" for="address">Address:</label>
          <div class="col-sm-3">
            <textarea name=address id=address row=3></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" name=submit id=submit class="btn btn-default">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <a href="index.php"><input type="button" class="btn btn-default" value=Cancel></a>
          </div>
        </div>
      </form>
    </div>

  </body>
  </html>
