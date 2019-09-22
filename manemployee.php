<?php
SESSION_START();
if(isset($_SESSION['empId']) AND $_SESSION['positionAccess'] <= 2){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Manage Employee</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
      <!--limit-->
      <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/dataTables.bootstrap.min.js"></script>
      <script>
        $(function () {
          $('#example1').DataTable()
        })
      </script>
      <style>
      * {
        border-radius: 0 !important;
      }
        .table > tbody > tr > td {
            vertical-align: middle;
        }
        .text-right{
            margin-bottom: 10px
          }
          
        img{
            width: 150px
            }
      </style>
  </head>
  <body>
    <?php include('koneksi.php');
    function showParts(){
      $query=queryRun("SELECT * FROM employee WHERE empStatus=1");
      while($hasil=queryTable($query)){
        $id=$hasil['empId'];
        $name=$hasil['empFName'] . " ". $hasil['empLName'];
        $position=$hasil['empPosition'];
        $photo=$hasil['empPhoto'];
        $phone=$hasil['empPhone'];
        $mail=$hasil['empMail'];
        ?>
        <tr>
          <td><img src="images/user/<?php echo $photo?>"></td>
          <td><?php echo $name?></td>
          <td><?php echo $id?></td>
          <td><?php echo $position?></td>
          <td><?php echo $phone?></td>
          <td><?php echo $mail?></td>
          <td>
            <a href="empedit.php?id=<?php echo $id?>" class="btn btn-primary">Edit</a>
            <a href="empdetail.php?id=<?php echo $id?>" class="btn btn-info">Detail</a>
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
      <h1>Employee List</h1>
      <div class=text-right>
        <a href="newemployee.php" class="btn btn-primary" role=button>New Employee</a>
      </div>
      <table id=example1 class="table table-striped">
        <thead>
          <tr>
            <th>Employee Photo</th>
            <th>Employee Name</th>
            <th>ID</th>
            <th>Position</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Info</th>
          </tr>
        </thead>
        <tbody>
            <?php
            showParts();
            ?>
        </tbody>
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
