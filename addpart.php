<?php
SESSION_START();
if(isset($_SESSION['empId'])){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Add Part</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/jquery.maskMoney.js"></script>
    <script>
        // just for the demos, avoids form submit
        $().ready(function() {
            $("#newpart").validate();
        });
    </script>
    <script>
      $(function() {
        $('#price').maskMoney({precision:0});
      })
    </script>
      <script>
        $(document).ready(function(){
            $('#partt').change(function(){
                var partt=$(this).val();
                $.ajax({
                    type:'POST',
                    url:'type.php',
                    data: 'partt='+partt,
                    success:function(response){
                        $('#part').html(response);
                    }
                });
            })
        });
    </script>
    <style>
        #newpart label.error {
            color: red;
        }

        * {
            border-radius: 0 !important;
        }

    </style>
    <style>
        * {
          border-radius: 0 !important;
        }
    </style>
  </head>
  <body>
    <?php include('koneksi.php');
    $id=$_GET['id'];
    
    function showPartt(){
        global $id;
        $query=queryRun("SELECT * FROM parttype WHERE parttId NOT IN (SELECT partType as parttId FROM carpart, part WHERE carpart.partId=part.partId AND cardId='$id')");
        while($hasil=queryTable($query)){
            $partId=$hasil['parttId'];
            $partName=$hasil['parttName'];
            ?>
            <option value="<?php echo $partId?>"><?php echo $partName?></option>
            <?php
        }
    }
    
    if(isset($_POST['submit'])){
        $part=$_POST['part'];
          $query="INSERT INTO carpart VALUES('$id', '$part', 1)";
          queryRun($query);
        header("location:mantype.php");
    }
      
    $query="SELECT * FROM card WHERE cardId='$id' AND cardStatus=1";
    $hasil=querySelect($query);
    $name=$hasil['cardName'];
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
      <h1>Add Car Part</h1>
      <form id="newpart" class="form-horizontal" method=post  enctype="multipart/form-data">
        <h2>Specification</h2>
        <div class="form-group">
          <label class="control-label col-sm-3" for="name">Car Name:</label>
          <div class="col-sm-9">
              <span id="car" name=car class="form-control" required><?php echo $name?></span>
          </div>
        </div>

        
        <div class="form-group">
          <label class="control-label col-sm-3" for="price">New Part Type:</label>
          <div class="col-sm-3">
            <select id="partt" name=partt class="form-control" required>
                <option value="">Select Part Type</option>
                <?php showPartt()?>
              </select>
          </div>
            
            <label class="control-label col-sm-3" for="type">New Part:</label>
            <div class="col-sm-3">
                <select id="part" name=part class="form-control" required>
                    <option value="">Select Part</option>
                </select>
            </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" name=submit id=submit class="btn btn-default">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <a href="mantype.php"><input type="button" class="btn btn-default" value=Cancel></a>
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
