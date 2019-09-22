<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Delivery Report</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script>
      $(function () {
        $('table').DataTable()
      })
    </script>
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    function showDel(){
      $query=queryRun("SELECT delId, delDate, delivererId, delStatus, empFName, empLName FROM delivery, employee WHERE delivererId=empId");
      while($hasil=queryTable($query)){
        $id=$hasil['delId'];
        $date=$hasil['delDate'];
        $del=$hasil['delivererId'];
        $statuss=$hasil['delStatus'];
          if($statuss==1){
              $status="Delivered";
          }else if($statuss==2){
              $status="In Delivery";
          }
        $courier=$hasil['empFName'] . " ".  $hasil['empLName'];
        ?>
        <tr>
              <td><?php echo $id?></td>
              <td><?php echo $courier?></td>
              <td><?php echo $date?></td>
              <td><?php echo $status?></td>
              <td>
                <a href="deldetail.php?id=<?php echo $id?>" class="btn btn-info">Detail</a>
                <a href="deldone.php?id=<?php echo $id?>" class="btn btn-success">Done</a>
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
      <h1>Delivery List</h1>
      <div class=text-right>
        <a href="newdelivery.php" class="btn btn-primary">New Delivery</a>
      </div>
      <br>
      <table id=table class="table table-striped">
        <thead>
          <tr>
            <th>Delivery ID</th>
            <th>Deliverer</th>
            <th>Date</th>
            <th>Status</th>
            <th>Info</th>
          </tr>
        </thead>
        <?php
        showDel();
        ?>
      </table>
    </div>

  </body>
  </html>

<?php
}else{
?>
<div class="container align-middle">
  <h1 class=align-middle>
    PLEASE LOG IN FIRST
  </h1>
</div>
<?php
} ?>
