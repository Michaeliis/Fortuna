<html>
<head>
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
    <title>Fortuna Login</title>
</head>
<body>
  <?php include('koneksi.php');
  SESSION_START();
  if(isset($_GET['logout'])){
    SESSION_DESTROY();
    SESSION_START();
  }

  if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $pass=$_POST['pass'];
    $query = "SELECT * FROM employee WHERE empId='$name' && empPass='$pass' && empStatus=1";
    $hasil = mysqli_fetch_array(mysqli_query($con, $query));
    if(!$hasil){
      echo "<script>alert('Wrong Username or Password');</script>";
    }else{
        if(($hasil['dateLimit']>date("Y-m-d")) && $hasil['empPosition']=='Trial'){
            queryRun("UPDATE employee SET empStatus=0 WHERE empId='$name'");
        }else{
              $_SESSION['empId']=$hasil['empId'];
              $_SESSION['name']=$hasil['empFName'];
              $pos=$hasil['empPosition'];
              if($pos=='Admin' ||$pos=='Trial'){
                $_SESSION['positionAccess']=1;
              }else if($pos=='Manager'){
                $_SESSION['positionAccess']=2;
              }else{
                $_SESSION['positionAccess']=3;
              }

              header('location:dashboard.php');
        }
    }
  }

  if(isset($_GET['lfail'])){
    ?><script>alert("You must login first to access");</script>
    <?php
  } ?>
  <div class=container>
    <center>
    <h1 class=text-center id=logo style="font-family: oneday; font-size:90px; padding-top:50px;">FORTUNA</h1>

    <form method=POST>
      <div class="form-group">
        <label class="control-label" for="uname" style="padding-top:60px">Username:</label>
        <input type="text" class="form-control" style=width:400px id="uname" name="name">
      </div>
      <div class="form-group">
        <label class="control-label" for="pass">Password:</label>
        <input type="password" class="form-control" style=width:400px id="pass" name="pass">
      </div>
      <div class="form-group">
        <input name=submit type=submit class=btn value="Sign In">
      </div>
    </form>
    </center>
  </div>
</body>
</html>
