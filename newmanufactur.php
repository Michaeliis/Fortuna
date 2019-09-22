<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>New Manufacture</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
    <style>
    * {
      border-radius: 0 !important;
    }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    $empId=$_SESSION['empId'];
    function showCar(){
      global $con;
      $query=queryRun("SELECT * FROM card WHERE cardStatus=1");
      while($hasil = queryTable($query)){
        $selectname=$hasil['cardName'];
        $selectid=$hasil['cardId'];
        ?>
        <option value="<?php echo $selectid;?>"><?php echo $selectname;?></option>
        <?php
      }
    }

    function showCust(){
      global $con;
      $query=queryRun("SELECT * FROM branch WHERE braStatus=1");
      while($hasil = queryTable($query)){
        $selectname=$hasil['braName'];
        $selectid=$hasil['braId'];
        ?>
        <option value="<?php echo $selectid;?>"><?php echo $selectname;?></option>
        <?php
      }
    }
    
    /*function buyParts($misPart, $misQuan){
        $date=date("Y-m-d");
        global $empId;
        for($i=0; $i<count($misPart); $i++){
            $part=$misPart[i];
            $quan=$misQuan[i];
            if(!$hello['there']){
              $suppId='01'.date("Ymd")."001";
            }else{
              $suppId='01'.date("Ymd").sprintf("%03d", substr($hello['there'], -3)+1);
            }
            $hasil=querySelect("SELECT supplierId FROM supplierdet WHERE partId='$part' AND sDetStatus=1");
            $supplierId=$hasil['supplierId'];
            queryRun("INSERT INTO supply VALUES('$suppId', '$supplierId', '$empId', '$date', 1");
            queryRun("INSERT INTO supplydet VALUES('$suppId', '$part', '$quan', '$price', 1");
        }
    }*/

    function newManufacture(){
        global $con;
        global $empId;
        $empId=$_SESSION['empId'];
        $braId=$_POST['customer'];
        $cardId=$_POST['car'];
        $quantity=$_POST['amount'];
        $prodStart=date("Y-m-d");
        $prodFinish="";
        $qprice=querySelect("SELECT cardPrice FROM card WHERE cardId='$cardId'");
        $cprice=$qprice['cardPrice'];
        $misPart=array();
        $misQuan=array();
        $misPrice=array();
        $query=queryRun("SELECT carpart.cardId, carpart.partId, part.partType, parttLimit FROM carpart, parttype, part WHERE carpart.partId=part.partId AND part.partType=parttId AND cardId='$cardId'");
        $ready=true;
        $tcost=0;
        while($hasil=queryTable($query)){
            $partId=$hasil['partId'];
            $parttLimit=$hasil['parttLimit'];
            $need=$parttLimit*$quantity;
            $check=querySelect("SELECT partQuantity, partPrice FROM part WHERE part.partId='$partId'");
            $stock=$check['partQuantity'];
            $price=$check['partPrice'];
            $tcost+=($parttLimit*$price);
            if($stock<$quantity){
                $ready=false;
                array_push($misPart, $partId);
                array_push($misQuan, ($need-$stock));
                array_push($misPrice, $price);
            }
        }
        if($ready){
            $query=queryRun("INSERT INTO production VALUES('', '$empId', '$braId', '$prodStart', '$prodFinish', 2)");
            $has=querySelect("SELECT MAX(prodId) AS thiss FROM production");
            $prodId=$has['thiss'];
            for($i=0; $i<$quantity; $i++){
                queryRun("INSERT INTO car VALUES('', '$cardId', '$cprice', 2)");
                $go=querySelect("SELECT MAX(carId) AS thiss FROM car");
                $carId=$go['thiss'];
                queryRun("INSERT INTO productiondet VALUES('$prodId', '$carId', '', $tcost, 2)");
            }
            $query=queryRun("SELECT carpart.cardId, carpart.partId, part.partType, parttLimit FROM carpart, parttype, part WHERE carpart.partId=part.partId AND part.partType=parttId AND cardId='$cardId'");
            $ready=true;
            while($hasil=queryTable($query)){
                $partId=$hasil['partId'];
                $parttLimit=$hasil['parttLimit'];
                $need=$parttLimit*$quantity;
                $check=querySelect("SELECT partQuantity, partPrice FROM part WHERE partId='$partId'");
                $stock=$check['partQuantity'];
                $price=$check['partPrice'];
                queryRun("UPDATE part SET partQuantity=partQuantity-$need WHERE partId='$partId'");
            }
        }else{
            for($i=0; $i<count($misPart); $i++){
                $part=$misPart[$i];
                $quan=$misQuan[$i];
                $price=$misPrice[$i];
                $date=date("Y-m-d");
                $hello=querySelect("SELECT MAX(supplyId) AS 'there' FROM supply");
                if(!$hello['there']){
                  $suppId='01'.date("Ymd")."001";
                }else{
                  $suppId='01'.date("Ymd").sprintf("%03d", substr($hello['there'], -3)+1);
                }
                $hasil=querySelect("SELECT supplierId FROM supplierdet WHERE partId='$part' AND sDetStatus=1");
                $supplierId=$hasil['supplierId'];
                queryRun("INSERT INTO supply VALUES('$suppId', '$supplierId', '$empId', '$date', 1)");
                queryRun("INSERT INTO supplydet VALUES('$suppId', '$part', '$quan', '$price', 1)");
                queryRun("UPDATE part SET partQuantity = 0 WHERE `part`.`partId` = $part)");
            }
            $query=queryRun("INSERT INTO production VALUES('', '$empId', '$braId', '$prodStart', 2)");
            $has=querySelect("SELECT MAX(prodId) AS thiss FROM production");
            $prodId=$has['thiss'];
            for($i=0; $i<$quantity; $i++){
                queryRun("INSERT INTO car VALUES('', '$cardId', '$cprice', 2)");
                $go=querySelect("SELECT MAX(carId) AS thiss FROM car");
                $carId=$go['thiss'];
                queryRun("INSERT INTO productiondet VALUES('$prodId', '$carId', '', $tcost, 2)");
            }
        }
    }

    if(isset($_POST['submit'])){
      newManufacture();
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
      <h1>New Manufacture</h1>
      <form class="form-horizontal" action="" method=post>
        <div class="form-group">
          <label class="control-label col-sm-3" for="car">Car Name:</label>
          <div class="col-sm-9">
            <select name=car id=car class=form-control>
              <option value="">Select Car</option>
              <?php showCar();?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-3" for="amount">Amount:</label>
          <div class="col-sm-3">
            <input type=number name=amount class=form-control id=amount>
          </div>
          <label class="control-label col-sm-2" for="customer">Branch:</label>
          <div class="col-sm-4">
            <select name=customer id=customer class=form-control>
              <option value="">Select customer</option>
              <?php showCust();?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button name=submit type="submit" class="btn btn-default" id=submit value=submit>Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
          </div>
        </div>

      </form>
    </div>
  </body>
  </html>

<?php
}else{
  header("location:login.php?lfail=1");
} ?>
