<?php
SESSION_START();
if(isset($_SESSION['empId']) AND $_SESSION['positionAccess'] <= 2){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>New Branch</title>

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
    if(isset($_POST['submit'])){
      $name=$_POST['name'];
      $there=mysqli_query($con, "SELECT MAX(braId) AS 'there' FROM branch");
      $hello=mysqli_fetch_array($there);
      $braId="";
      if(!$hello['there']){
        $braId="000001";
      }else{
        $braId=sprintf("%06d", ($hello['there']+1));
      }
      $braPhone=$_POST['phone'];
      $braManager=$_POST['manager'];
      $braMail=$_POST['mail'];
      $braAddress=$_POST['address'];
      $query="INSERT INTO branch VALUES('$braId', '$name', '$braAddress', '$braManager', '$braPhone', '$braMail', 1)";
      queryRun($query);
    }

    function showManager(){
      global $con;
      $query=queryRun("SELECT * FROM employee WHERE empPosition='Manager'");
      while($hasil=queryTable($query)){
        ?>
        <option value=<?php echo $hasil['empId']?>><?php echo $hasil['empFName']. " ". $hasil['empLName']?></option>
        <?php
      }
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
      <h1>New Branch</h1>
      <form class="form-horizontal" action="" method=post>
        <div class="form-group">
          <label class="control-label col-sm-3" for="name">Branch Name:</label>
          <div class="col-sm-9">
            <input name=name type="text" class="form-control" id="name" placeholder="Enter name">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="phone">Phone number:</label>
          <div class="col-sm-3">
            <input name=phone type="text" class="form-control" id="phone">
          </div>
          <label class="control-label col-sm-3" for="mail">Email:</label>
          <div class="col-sm-3">
            <input name=mail type="text" class="form-control" id="mail" placeholder="Insert email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="address">Address:</label>
          <div class="col-sm-3">
            <textarea name=address id=address rows=3 cols=40></textarea>
          </div>
          <label class="control-label col-sm-3" for="manager">Manager:</label>
          <div class="col-sm-3">
            <select name=manager class="form-control" id="manager" placeholder="Insert email">
              <option value="">Select Manager</option>
              <?php showManager()?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" name=submit id=submit class="btn btn-default">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <a href="mancust.php"><input type="button" class="btn btn-default" value=Cancel></a>
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
