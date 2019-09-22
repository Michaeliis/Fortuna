<!DOCTYPE html>
<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
<html lang="en">
<head>
  <title>Manufacture History</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/css.css">
  <!--<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.3.1.min.js"></script>-->
  
    <link rel=stylesheet href="css/daterangepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.js"></script>
    <script>
        $(document).ready(function(){
            $('#grouping').change(function(){
                var group=$(this).val();

                $.ajax({
                    type:'POST',
                    url:'hisman.php',
                    data: 'group='+group,
                    success:function(response){
                        $('#example1').html(response);
                    }
                });
            })
        });
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
        });
    </script>
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
    <?php
    include('koneksi.php');
    if(isset($_POST['asubmit'])){
        $date=explode(" - ", $_POST['daterange']);
        $from=$date[0];
        $to=$date[1];
    }
    function showMan(){
        $query=queryRun("SELECT productiondet.prodId, production.braId, productiondet.carId, card.cardName, prodStart, prodDetFinish, prodDetStatus, braName, productiondet.prodDetCost FROM production, branch, productiondet, car, card WHERE production.braId=branch.braId AND productiondet.prodId=production.prodId AND productiondet.carId=car.carId AND car.cardId=card.cardId");
        while($hasil = queryTable($query)){
            $prodid=$hasil['prodId'];
            $cost=$hasil['prodDetCost'];
            $branch=$hasil['braName'];
            $carid=$hasil['carId'];
            $card=$hasil['cardName'];
            $start=$hasil['prodStart'];
            $finish=$hasil['prodDetFinish'];
            $status=$hasil['prodDetStatus'];
            $statuss="";
            if($status==1){
                $statuss="Done";
            }else if($status==2){
                $statuss="In Process";
            }else if($status==0){
                $statuss="Cancelled";
            }
            ?>
            <tr>
                <td><?php echo $prodid?></td>
                <td><?php echo $branch?></td>
                <td><?php echo $carid?></td>
                <td><?php echo $card?></td>
                <td><?php echo $start?></td>
                <td><?php echo $finish?></td>
                <td><?php echo $statuss?></td>
                <td><?php echo $cost?></td>
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
  <h1>Manufacture History</h1>
    
    <div class=text-right style=margin-bottom:10px>
        <button type="button" data-toggle="collapse" class="btn btn-default" data-target="#advanced">Advanced</button>
        <select id=grouping>
            <option value="none">No Grouping</option>
            <option value="group">Group By Production ID</option>
        </select>
      </div>


      <div id=advanced class=collapse>
        <form class="form-horizontal" action="" method=post>
          <h3>Advanced Search</h3>
          <div class=form-group>
            <label class="control-label col-sm-3" for="prof">Date Range:</label>
            <div class="col-sm-3">
              <input name=daterange type="text" class="form-control pull-right" id="daterange">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button name=asubmit type="submit" class="btn btn-default" id=asubmit value=submit>Submit</button>
              <button type="reset" class="btn btn-default">Reset</button>
            </div>
          </div>
      </form>
    </div>
    <form method=POST>
        <table name=example1 id=example1 class="table table-striped">
            <thead>
                <tr>
                <th>Production ID</th>
                <th>Branch</th>
                <th>Car Id</th>
                <th>Car Name</th>
                <th>Date Start</th>
                <th>Date Finish</th>
                <th>Status</th>
                <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php showMan()?>
            </tbody>
        </table>
    </form>
</div>
</body>
</html>
<?php
}else{
  header("location:login.php?lfail=1");
} ?>
