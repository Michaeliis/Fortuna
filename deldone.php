<?php include("koneksi.php");
$id=$_GET['id'];
queryRun("UPDATE delivery SET delStatus=1 WHERE delId='$id'");
queryRun("UPDATE deliverydetail SET deliverydetail.delDetStatus=1 WHERE deliverydetail.delId='$id'");
$hasil=querySelect("SELECT delivererId AS 'courid' FROM delivery WHERE delId='$id'");
$courier=$hasil['courid'];
queryRun("UPDATE employee SET empStatus=1 WHERE empId='$courier'");
queryRun("UPDATE car SET car.carStatus=3 WHERE car.carId IN(SELECT deliverydetail.carId FROM deliverydetail WHERE deliverydetail.delId='$id')");
header("location:mandel.php");
?>