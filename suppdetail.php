<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Supplier Detail</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script>
          function del(){
              var stat=confirm("Are you sure you want to delete this supplier?");
              if(stat){
                  var id= <?php echo $_GET['id']?>;
                  
                  $.ajax({
                        type:'POST',
                        url:'del.php',
                        data: {id: id, func: 'supplier'}
                    });
              }
          }
      </script>
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    $id=$_GET['id'];
    $hasil=querySelect("SELECT * FROM supplier WHERE suppStatus=1");
    $name=$hasil['suppName'];
    $phone=$hasil['suppPhone'];
    $mail=$hasil['suppMail'];
    $address=$hasil['suppAddress'];
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
        
        <div class="col-sm-9">
            <h1>Supplier Name: <?php echo $name?></h1>
            <h3>Branch ID: <?php echo $id?></h3>
            <h3>Email: <?php echo $mail?></h3>
            <h3>Phone: <?php echo $phone?></h3>
            <h3>Address: <?php echo $address?></h3>
            
            <a href="braedit.php?id=<?php echo $id ?>"><button class='btn btn-primary' style="font-size:20px">Edit</button></a>
            <button class='btn btn-danger' style="font-size:20px" onclick="del()">Remove</button>
            <a href="mansupp.php"><button class='btn' style="font-size:20px">Back</button></a>
        </div>
    </div>
  </body>
  </html>

<?php
}else{
header("location:login.php?lfail=1");
} ?>