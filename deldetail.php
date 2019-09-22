<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Delivery Detail</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script>
          $(function () {
            $('table').DataTable()
          })
        </script>
      <script>
          function del(){
              var stat=confirm("Are you sure you want to delete this account?");
              if(stat){
                  var id= <?php echo $_GET['id']?>;
                  
                  $.ajax({
                        type:'POST',
                        url:'del.php',
                        data: {id: id, func: 'part'}
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
    $query="SELECT delivery.delDate, delivery.delStatus, employee.empFName, employee.empLName FROM delivery, employee WHERE delivery.delivererId=employee.empId AND delivery.delId='$id'";
    $hasil=querySelect($query);
    $date=$hasil['delDate'];
    $courrier=$hasil['empFName']." ".$hasil['empLName'];
    $stat=$hasil['delStatus'];
    $status="";
    if($stat==1){
        $status="Delivered";
    }else{
        $status="In Delivery";
    }
    function hasil(){
        global $id;
        $query=queryRun("SELECT deliverydetail.delId, deliverydetail.carId, card.cardName, branch.braName FROM deliverydetail, card, branch, car, production, productiondet WHERE card.cardId=car.cardId AND  deliverydetail.carId=car.carId AND deliverydetail.delId='$id' AND production.braId=branch.braId AND production.prodId=productiondet.prodId AND car.carId=productiondet.carId");
        while($hasil=queryTable($query)){
            $cardName=$hasil['cardName'];
            $carId=$hasil['carId'];
            $braName=$hasil['braName'];
            ?>
            <tr>
                <td><?php echo $carId?></td>
                <td><?php echo $cardName?></td>
                <td><?php echo $braName?></td>
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
        <h1>Delivery ID: <?php echo $id?></h1>
        <h3>Delivery Date: <?php echo $date?></h3>
        <h3>Courrier: <?php echo $courrier?></h3>
        <h3>Status: <?php echo $status?></h3><br>
        <table class="table table-striped">
            <thead>
                <th>Car ID</th>
                <th>Car Name</th>
                <th>Branch</th>
            </thead>
            <tbody>
                <?php echo hasil()?>
            </tbody>
        </table>
        <a href="mandel.php" class="btn btn-primary">Back</a>
    </div>
  </body>
  </html>

<?php
}else{
header("location:login.php?lfail=1");
} ?>
