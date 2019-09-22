<?php
SESSION_START();
if(isset($_SESSION['empId']) AND $_SESSION['positionAccess'] <= 2){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Manage Car Type</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
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
    <style>
    * {
      border-radius: 0 !important;
    }
    img{
        width: 150px
        }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    
    function showCars(){
        $thisqu="SELECT * FROM card WHERE cardStatus=1";
        if(isset($_POST['asubmit'])){
            $prof=$_POST['prof'];
            $prot=$_POST['prot'];
            $thisqu.=" AND card.cardPrice<'$prot' AND card.cardPrice>'$prof'"; 
        }
      $query=queryRun($thisqu);
      while($hasil=queryTable($query)){
        $id=$hasil['cardId'];
        $name=$hasil['cardName'];
        $price=$hasil['cardPrice'];
        $photo=$hasil['cardPhoto'];
        $type=$hasil['cardType'];
        ?>
        <tr>
          <td><img src="images/car/<?php echo $photo?>"></td>
          <td><?php echo $name?></td>
          <td><?php echo $id?></td>
          <td><?php echo "Rp. ". number_format($price)?></td>
          <td><?php echo $type?></td>
          <td>
            <a href="typeedit.php?id=<?php echo $id?>" class="btn btn-primary">Edit</a>
            <a href="typedetail.php?id=<?php echo $id?>" class="btn btn-info">Detail</a>
            <a href="addpart.php?id=<?php echo $id?>" class="btn btn-primary">Add Part</a>
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
      <h1>Car Model List</h1>
      <div class=text-right>
        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#advanced">Advanced</button>
        <a href="newcar.php" class="btn btn-primary">New Car Model</a>
      </div>
      <br>
      <div id=advanced class=collapse>
        <form class="form-horizontal" action="" method=post>
          <h3>Advanced Search</h3>
          <div class=form-group>
            <label class="control-label col-sm-3" for="prof">Price From:</label>
            <div class="col-sm-3">
              <input name=prof type="number" class="form-control" id="prif" required>
            </div>
            <label class="control-label col-sm-3" for="prot" required>To:</label>
            <div class="col-sm-3">
              <input name=prot type="number" class="form-control" id="prit">
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
      <table id=table class="table table-striped">
        <thead>
          <tr>
            <th>Model Photo</th>
            <th>Model Name</th>
            <th>ID</th>
            <th>Price</th>
            <th>Type</th>
            <th>Info</th>
          </tr>
        </thead>
        <?php
        showCars();
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
