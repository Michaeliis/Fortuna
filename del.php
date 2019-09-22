<?php
include("koneksi.php");
$id=$_POST['id'];
$func=$_POST['func'];

switch($func){
    case 'part':
        queryRun("UPDATE part SET part.partStatus=0 WHERE part.partId='$id'");
        break;
    case 'employee':
        queryRun("UPDATE employee SET employee.empStatus=0 WHERE employee.empId='$id'");
        break;
    case 'branch':
        queryRun("UPDATE branch SET branch.braStatus=0 WHERE branch.braId='$id'");
        break;
    case 'car':
        queryRun("UPDATE card SET card.cardStatus=0 WHERE card.cardId='$id'");
        break;
    case 'supplier':
        queryRun("UPDATE supplier SET supplier.suppStatus=0 WHERE supplier.suppId='$id'");
        break;
}
?>
