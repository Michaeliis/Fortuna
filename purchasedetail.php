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
    $query="SELECT supply.supplyId, employee.empFName, employee.empLName, supply.supplyDate FROM supply, employee WHERE supply.empId=employee.empId AND supply.supplyId='$id'";
    $hasil=querySelect($query);
    $date=$hasil['supplyDate'];
    $requester=$hasil['empFName']." ".$hasil['empLName'];
    
    function hasil(){
        global $id;
        $query=queryRun("SELECT supplydet.partId, supplydet.supplyQuantity, supplydet.supplyPrice, part.partName FROM supplydet, supply, part WHERE supplydet.partId=part.partId AND supplydet.supplyId=supply.supplyId AND supplydet.supplyId='$id'");
        while($hasil=queryTable($query)){
            $partId=$hasil['partId'];
            $partName=$hasil['partName'];
            $quan=$hasil['supplyQuantity'];
            $price=$hasil['supplyPrice'];
            $tprice=$price*$quan;
            ?>
            <tr>
                <td><?php echo $partId?></td>
                <td><?php echo $partName?></td>
                <td><?php echo $quan?></td>
                <td><?php echo $price?></td>
                <td><?php echo number_format($tprice)?></td>
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
        <h1>Purchase ID: <?php echo $id?></h1>
        <h3>Purchase Date: <?php echo $date?></h3>
        <h3>Requester: <?php echo $requester?></h3><br>
        <table class="table table-striped">
            <thead>
                <th>Part ID</th>
                <th>Part Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </thead>
            <tbody>
                <?php echo hasil()?>
            </tbody>
        </table>
        <a href="hispurchase.php" class="btn btn-primary">Back</a>
    </div>
  </body>
  </html>

<?php
}else{
header("location:login.php?lfail=1");
} ?>
