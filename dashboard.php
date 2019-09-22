<!DOCTYPE html>
<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <html lang="en">
  <head>
    <title>Dashboard</title>
      
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
	<script src="js/utils.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel=stylesheet href="css/daterangepicker.css">
      <script src="js/moment.min.js"></script>
      <script src="js/daterangepicker.js"></script>
      <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
        });
    </script>
    <script src="js/daterangepicker.js"></script>
    <link rel="stylesheet" href="css/css.css">
      
      
    <style>
    * {
      border-radius: 0 !important;
    }
        
    </style>
  </head>
  <body>
  <?php include("koneksi.php");
    $dateStart=0;
    $dateFinish=0;
    if(isset($_POST['daterange'])){
        $data= explode(" - ", $_POST['daterange']);
        $dateStart=$data[0];
        $dateFinish=$data[1];
    }else{
        $dateStart=date('Y/m/d', strtotime("-1 Month"));
        $dateFinish=date('Y/m/d');
        
    }
    $hasil=querySelect("SELECT SUM(supplydet.supplyQuantity*supplydet.supplyPrice) AS 'expense' FROM supplydet, supply WHERE supplydet.supplyId=supply.supplyId AND supply.supplyDate<='$dateFinish' AND supply.supplyDate>='$dateStart'");
    
    $expense=$hasil['expense'];
    
    $hasil=querySelect("SELECT SUM(car.carPrice) AS 'income' FROM car, production, productiondet WHERE production.prodStart>='$dateStart' AND production.prodStart<='$dateFinish' AND production.prodId=productiondet.prodId AND productiondet.carId=car.carId");
    
    $income=$hasil['income'];
    
    $hasil=querySelect("SELECT COUNT(car.carPrice) AS 'count' FROM car, production, productiondet WHERE production.prodStart>='$dateStart' AND production.prodStart<='$dateFinish' AND production.prodId=productiondet.prodId AND productiondet.carId=car.carId");
    
    $count=$hasil['count'];
    function showDay(){
        global $dateFinish;
        global $dateStart;
        $start=$dateStart;
        while (strtotime($start) <= strtotime($dateFinish)) {
            $now=date('d', strtotime($start));
            echo "$now".", ";
            $start = date ("Y/m/d", strtotime("+1 day", strtotime($start)));
        }
    }
    
    function showSold(){
        global $dateFinish;
        global $dateStart;
        $start=$dateStart;
        while (strtotime($start) <= strtotime($dateFinish)) {
            $hasil=querySelect("SELECT COUNT(productiondet.prodId) AS 'count' FROM production, productiondet WHERE production.prodStart='$start'");
            $now=date('d', strtotime($start));
            $count=$hasil['count'];
            echo "$count".", ";
            $start = date ("Y/m/d", strtotime("+1 day", strtotime($start)));
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
            <li><a class=hider href="newpurchase.php">New Purchase</a></li>
            <li><a class=hider href="newmanufactur.php">New Manufacture</a></li>
            <li><a class=hider href="newdelivery.php">New Delivery</a></li>
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
      <h1>Dashboard</h1>
      <div class="row placeholders">
          <form method=post>
            <input name=daterange type="text" class="form-control" id="daterange"><br><input type=submit name=submit id=submit value=Submit class="btn btn-primary"><br><br>
          </form>
        <div class="col-xs-6 col-sm-3 placeholder">
          <img src="images/income.png" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
          <h4>Income</h4>
          <span class="text-muted"><?php echo "Rp. ".number_format($income)?></span>
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">
          <img src="images/expense.png" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
          <h4>Expense</h4>
          <span class="text-muted"><?php echo "Rp. ".number_format($expense)?></span>
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">
          <img src="images/sold.png" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
          <h4>Cars Sold</h4>
          <span class="text-muted"><?php echo $count?></span>
        </div>
        
        <div class="col-sm-12" style="padding-top:50px">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php showDay()?>],
        datasets: [{
            label: '# of Car Sold',
            data: [<?php showSold()?>],
            backgroundColor: [
                'rgba(0, 0, 0, 0.3)'
                
            ],
            borderColor: [
                'rgba(0,0,0,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
  </body>
  </html>
  <?php
}else{
  header("location:login.php?lfail=1");
} ?>
