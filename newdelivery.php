<!DOCTYPE html>
<?php
SESSION_START();
if(isset($_SESSION['empId']) AND $_SESSION['positionAccess'] <= 2){
  ?>
<html lang="en">
<head>
  <title>New Delivery</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/css.css">
  <!--<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.3.1.min.js"></script>-->
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel=stylesheet href="css/daterangepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>    
    
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
</head>
<body>
    <?php
    include('koneksi.php');
    if(isset($_POST['asubmit'])){
        $date=explode(" - ", $_POST['daterange']);
        $from=$date[0];
        $to=$date[1];
    }
    
    if(isset($_POST['submit'])){
        $date=date("Y-m-d");
        $idl=$_POST['id'];
        $courier=$_POST['courier'];
        queryRun("INSERT INTO delivery VALUES('', '$date', '$courier', 2)");
        $hasil=querySelect("SELECT MAX(delId) AS 'there' FROM delivery");
        $idn=$hasil['there'];
        for($i=0; $i<count($_POST['id']); $i++){
            $carid=$idl[$i];
            queryRun("INSERT INTO deliverydetail VALUES('$idn', '$carid', 2)");
            queryRun("UPDATE car SET carStatus=4 WHERE carId='$carid'");
            queryRun("UPDATE employee SET empStatus=2 WHERE empId='$courier'");
        }
    }
    
    function showCourier(){
        $query=queryRun("SELECT * FROM employee WHERE empPosition='courier' AND empStatus=1");
        while($hasil=queryTable($query)){
            $empname=$hasil['empFName']. " ".$hasil['empLName'];
            $empid=$hasil['empId'];
            ?>
            <option value="<?php echo $empid?>"><?php echo $empname?></option>
            <?php
        }
    }
    
    function showMan(){
        $query=queryRun("SELECT productiondet.prodId, production.braId, productiondet.carId, card.cardType, car.carPrice, card.cardName, car.carStatus, prodStart, prodDetFinish, prodStatus, braName FROM production, branch, productiondet, car, card WHERE production.braId=branch.braId AND productiondet.prodId=production.prodId AND productiondet.carId=car.carId AND car.cardId=card.cardId AND car.carStatus=1;");
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
        }
        ?>
        <tr>
            <td><input type=checkbox id=id name=id[] value="<?php echo $id?>"><?php echo $id?></td>
            <td><?php echo $name?></td>
            <td><?php echo $cust?></td>
            <td><?php echo $date?></td>
            <td><?php echo $finish?></td>
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

<div class="container">
  <h1>New Delivery</h1>
<form method="POST">
    <h3>Select Courier</h3>
    <select id=courier name=courier required class="col-sm-6">
        <option value="">Select Courier</option>
        <?php showCourier()?>
    </select><br><br><br>
    <h3>Select Car to Deliver</h3>
    <script>
      $(function () {
        $('table').DataTable()
      })
    </script>
    
    <table id=#example1 class="table table-striped">
        <thead>
            <tr>
                <th>Production ID</th>
                <th>Branch</th>
                <th>Branch</th>
                <th>Date Start</th>
                <th>Date Finish</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php showMan()?>
        </tbody>
    </table>
    <input class="btn btn-success" type=submit value=Deliver name=submit id=submit>
</form>
</div>
</body>
</html>
<?php
}else{
  header("location:login.php?lfail=1");
} ?>