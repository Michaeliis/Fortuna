<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Purchase History</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
      <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
      <link rel=stylesheet href="css/daterangepicker.css">
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
      
    <script>
        $(document).ready(function(){
            $('#grouping').change(function(){
            var group=$(this).val();
                $.ajax({
                    type:'POST',
                    url:'group.php',
                    data: 'group='+group,
                    success:function(response){
                        $('table').DataTable();
                        $('#example1').html(response);
                        $('table').DataTable();
                    }
                });
            })
        });
    </script>
      
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    function showPurchase(){
      global $con;
      $query=queryRun("SELECT supply.supplyId, supplierId, supplyDate, suppname, partName, supplyQuantity, supplyPrice FROM supplier, part, supply, supplydet WHERE supplydetstatus=1 AND supplydet.partId=part.partId AND supplierid=suppid AND supplydet.supplyId=supply.supplyId;");
      while($hasil=queryTable($query)){
        $supplyid=$hasil['supplyId'];
        $suppliername=$hasil['suppname'];
        $supplydate=$hasil['supplyDate'];
        $partname=$hasil['partName'];
        $quantity=$hasil['supplyQuantity'];
        $price=$hasil['supplyPrice'];
        $pricetotal=$price*$quantity;
        ?>
        <tr>
          <td>
            <?php echo $supplyid?>
          </td>
          <td>
            <?php echo $partname?>
          </td>
          <td>
            <?php echo $suppliername?>
          </td>
          <td>
            <?php echo $supplydate?>
          </td>
          <td>
            <?php echo "Rp. ".number_format($price)?>
          </td>
          <td>
            <?php echo $quantity?>
          </td>
          <td>
            <?php echo "Rp. ".number_format($pricetotal)?>
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
      <h1>Purchase History</h1>
        <div class=text-right style=margin-bottom:10px>
        <button type="button" data-toggle="collapse" class="btn btn-default" data-target="#advanced">Advanced</button>
        <select id=grouping>
          <option value="none">No grouping</option>
          <option value="group">Group by Supply ID</option>
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
      <table id=example1 class="table table-striped">
        <thead>
          <tr>
            <th>Supply ID</th>
            <th>Part Name</th>
            <th>Supplier</th>
            <th>Date</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Price Total</th>
          </tr>
        </thead>
        <?php
        showPurchase();
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
