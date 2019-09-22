<!DOCTYPE html>
<?php
SESSION_START();
if(isset($_SESSION['empId']) AND $_SESSION['positionAccess'] <= 2){
  ?>
<html lang="en">
<head>
  <title>Manage Car</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/css.css">
  <!--<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.3.1.min.js"></script>-->
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/dataTables.bootstrap.min.js"></script>
      <script>
        $(function () {
          $('#example1').DataTable()
        })
      </script>
      <style>
      * {
        border-radius: 0 !important;
      }
        .table > tbody > tr > td {
            vertical-align: middle;
        }
        .text-right{
            margin-bottom: 10px
          }
          
        img{
            width: 150px
            }
      </style>
</head>
<body>
  <?php include('koneksi.php');
    
    function changeStatus($change){
        $id=$_POST['id'];
        for($i=0; $i<count($id); $i++){
            $idn=$id[$i];
            queryRun("UPDATE car SET carStatus=$change WHERE carId='$idn'");
            queryRun("UPDATE productiondet SET prodDetStatus=$change WHERE carId='$idn'");
        }
    }
    
    function finishStatus($change){
        $id=$_POST['id'];
        for($i=0; $i<count($id); $i++){
            $idn=$id[$i];
            queryRun("UPDATE car SET carStatus=$change WHERE carId='$idn'");
            $date=date("Y-m-d");
            queryRun("UPDATE productiondet SET prodDetStatus=$change, prodDetFinish='$date' WHERE carId='$idn'"); 
            
        }
    }
    
    if(isset($_POST['cancel'])){
        changeStatus(0);
    }
    
    if(isset($_POST['finish'])){
        finishStatus(1);
    }
    
    
  function showCars(){
    $query=queryRun("SELECT productiondet.prodId, production.braId, productiondet.carId, card.cardType, car.carPrice, card.cardName, car.carStatus, prodStart, prodDetFinish, prodStatus, braName FROM production, branch, productiondet, car, card WHERE production.braId=branch.braId AND productiondet.prodId=production.prodId AND productiondet.carId=car.carId AND car.cardId=card.cardId;");
    while($hasil=queryTable($query)){
      $id=$hasil['carId'];
      $name=$hasil['cardName'];
      $type=$hasil['cardType'];
      $cust=$hasil['braName'];
      $date=$hasil['prodStart'];
      $finish=$hasil['prodDetFinish'];
      $price=$hasil['carPrice'];
      $statuss=$hasil['carStatus'];
        $status="";
        if($statuss==1){
            $status="Ready";
        }else if($statuss==2){
            $status="In Process";
        }else if($statuss==0){
            $status="Canceled";
        }else if($statuss==3){
            $status="Delivered";
        }else if($statuss==4){
            $status="In Delivery";
        }
      ?>
      <tr>
        <td><input type=checkbox id=id name=id[] value="<?php echo $id?>"><?php echo $id?></td>
        <td><?php echo $name?></td>
        <td><?php echo $type?></td>
        <td><?php echo $cust?></td>
        <td><?php echo $date?></td>
        <td><?php echo $finish?></td>
        <td><?php echo $price?></td>
        <td>
          <?php echo $status?>
        </td>
      </tr>
      <?php
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
    <h1>Cars List</h1>
      <form method="post">
          <div style="margin-bottom:15px">
              Change Status: 
              <input type=submit class="btn btn-success" id=finish name=finish value="Finish">
              <input type=submit class="btn btn-warning" id=cancel name=cancel value="Cancel">
          </div>
    <table class="table table-striped" id=example1>
      <thead>
        <tr>
          <th>Car ID</th>
          <th>Car Name</th>
          <th>Type</th>
          <th>Customer</th>
          <th>Production Date</th>
          <th>Finished Date</th>
          <th>Price</th>
          <th>Status</th>
        </tr>
      </thead>
      <?php
      showCars();
      ?>
    </table>
      </form>
  </div>

</body>
</html>
<?php
}else{
  header("location:login.php?lfail=1");
} ?>