<!DOCTYPE html>
<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
<html lang="en">
<head>
  <title>New Purchase</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/css.css">
  <!--<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.3.1.min.js"></script>-->
  <script src="js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#supplier').change(function(){
                var suppid=$(this).val();

                $.ajax({
                    type:'POST',
                    url:'part.php',
                    data: 'suppid='+suppid,
                    success:function(response){
                        $('#name').html(response);
                    }
                });
            })
        });
        $(document).ready(function(){
                var suppid=$('#supplier').val();

                $.ajax({
                    type:'POST',
                    url:'part.php',
                    data: 'suppid='+suppid,
                    success:function(response){
                        $('#name').html(response);
                    }
                });
        });
    </script>
  <style>
  * {
    border-radius: 0 !important;
  }
  </style>
</head>
<body>
  <?php include_once('koneksi.php');
  $there=mysqli_query($con, "SELECT MAX(supplyId) AS 'there' FROM supply");
  $hello=mysqli_fetch_array($there);

  if(!isset($_SESSION['priceTotal'])){
    $_SESSION['priceTotal']=0;
  }

  if(!isset($_SESSION['suppId'])){
    if(!$hello['there']){
      $_SESSION['suppId']='01'.date("Ymd")."001";
    }else{
      $_SESSION['suppId']='01'.date("Ymd").sprintf("%03d", substr($hello['there'], -3)+1);
    }
  }
  $date=date("Y-m-d");
  $priceTotal=0;
  $userId=$_SESSION['empId'];

  function showPart(){
    global $con;
    $query=queryRun("SELECT * FROM part WHERE partStatus=1");
    while($hasil = queryTable($query)){
      $selectname=$hasil['partName'];
      $selectid=$hasil['partId'];
      ?>
      <option value="<?php echo $selectid;?>"><?php echo $selectname;?></option>
      <?php
    }
  }

  function showSupplier(){
    global $con;
    $query=queryRun("SELECT * FROM supplier WHERE suppStatus=1");
    while($hasil = queryTable($query)){
      $selectname=$hasil['suppName'];
      $selectid=$hasil['suppId'];
      ?>
      <option value="<?php echo $selectid;?>" <?php if(isset($_SESSION['supplier'])){if($selectid==$_SESSION['supplier']){echo "selected";}}?>><?php echo $selectname;?></option>
      <?php
    }
  }

  function showPurchase(){
      $_SESSION['priceTotal']=0;
    if(isset($_SESSION['productId'])){
      for($i=0; $i<count($_SESSION['productId']); $i++){
        global $supplyId;
        $suppId=$_SESSION['supplier'];
        $prodId=$_SESSION['productId'][$i];
        $quantity=$_SESSION['productQuan'][$prodId];
          $query="SELECT * FROM part WHERE partid='$prodId'";
          $hasil=querySelect($query);
        $price=$hasil['partPrice'];
        $name=$hasil['partName'];
          $query="SELECT * FROM supplier WHERE suppid='$suppId'";
          $hasil=querySelect($query);
        $sname=$hasil['suppName'];
        $prit=$price*$quantity;
        $_SESSION['priceTotal']+=$prit;

        ?>
        <tr>
          <td><?php echo "$prodId"?></td>
          <td><?php echo "$name"?></td>
          <td><?php echo "$sname"?></td>
          <td><?php echo "$quantity"?></td>
          <td><?php echo "$prit"?></td>
        </tr>
        <?php
      }
    }
  }

  function insertPurchase(){
    global $con;
    global $supplyId;
    global $userId;
    global $date;
    $partId = $_POST['name'];
    $amount = $_POST['amount'];
    if(!isset($_SESSION['purchase'])){
        if(!isset($_SESSION['supplier'])){
            $_SESSION['supplier']=$_POST['supplier'];
        }
        $supplierId=$_SESSION['supplier'];
        $suppId=$_SESSION['suppId'];
      $_SESSION['purchase']="INSERT INTO supply VALUES('$suppId', '$supplierId', '$userId', '$date', 1)";
      
      $_SESSION['productId']=array();
      $_SESSION['productQuan']=array();
    }
      if(!in_array("$partId", $_SESSION['productId'])){
          array_push($_SESSION['productId'], "$partId");
          $_SESSION['productQuan']["$partId"]=$amount;
      }else{
          $_SESSION['productQuan']["$partId"]+=$amount;
      }
  }

  function executePurchase(){
    for($i=0; $i<count($_SESSION['productId']); $i++){
      global $supplyId;
      $prodId=$_SESSION['productId'][$i];
      $quantity=$_SESSION['productQuan']["$prodId"];
      $query="SELECT * FROM part WHERE partid=$prodId";
      $hasil=querySelect($query);
      $price=$hasil['partPrice'];
      $name=$hasil['partName'];
        $suppId=$_SESSION['suppId'];
        queryRun($_SESSION['purchase']);
      $query = "INSERT INTO supplyDet VALUES('$suppId', '$prodId', $quantity, $price, 1)";
      queryRun($query);
        $query="UPDATE part SET partQuantity = partQuantity + $quantity WHERE `part`.`partId` = $prodId";
        queryRun($query);
    }
    unset($_SESSION['productId']);
    unset($_SESSION['productQuan']);
    unset($_SESSION['purchase']);
    unset($_SESSION['suppId']);
    unset($_SESSION['supplier']);
    unset($_SESSION['priceTotal']);
  }
    
    if(isset($_POST['cancel'])){
        unset($_SESSION['productId']);
        unset($_SESSION['productQuan']);
        unset($_SESSION['purchase']);
        unset($_SESSION['suppId']);
        unset($_SESSION['supplier']);
        unset($_SESSION['priceTotal']);
      }

  if(isset($_POST['submit'])){
    insertPurchase();
  }

  if(isset($_POST['submission'])){
    executePurchase();
  } ?>

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
    <h1>New Purchase</h1>
    <div class=row>
      <div class=col-lg-6>

        <form class="form-horizontal" action="" method=post>
          
          <div class="form-group">
            <label class="control-label col-sm-3" for="cust">Supplier:</label>
            <div class="col-sm-9">
              <select name=supplier id=supplier class=form-control <?php if(isset($_SESSION['supplier'])) echo "disabled"?>>
                <option value="">Select Supplier</option>
                <?php showSupplier();?>
              </select>
            </div>
          </div>
            
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Part Name:</label>
                <div class="col-sm-9">
                  <select name=name id=name class=form-control>
                    <option value="">Select Part</option>
                    
                  </select>
                </div>
              </div>


          <div class="form-group">
            <label class="control-label col-sm-3" for="amount">Amount:</label>
            <div class="col-sm-3">
              <input type=number name=amount class=form-control id=amount>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <input type="submit" name=submit  class="btn btn-default" id=submit value=Submit>
              <input type="submit" name=cancel id=cancel class="btn btn-default" value=Reset>
                <a href="dashboard.php" class="btn btn-default">Back</a><br><br><br>
              <input type=submit id=submission class=btn name=submission value=Done>
            </div>
          </div>
        </form>
      </div>

      <div class=col-lg-6>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Part ID</th>
              <th>Part Name</th>
              <th>Supplier</th>
              <th>Quantity</th>
              <th>Price</th>
            </tr>
          </thead>
          <?php
          showPurchase();
          ?>
        </table>
        <?php
        if(isset($_SESSION['priceTotal'])){?>
          Price Total : <?php echo $_SESSION['priceTotal']?><br>
          <?php
        }else{
          echo "Price Total : 0";
        }
        ?>
      </div>
  </div>
</div>
</body>
</html>
<?php
}else{
header("location:login.php?lfail=1");
} ?>
