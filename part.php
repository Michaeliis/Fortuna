<?php
include("koneksi.php");
$id=$_POST['suppid'];
$query=queryRun("SELECT * FROM supplierdet, part WHERE partStatus=1 AND supplierdet.partId=part.partId AND supplierId='$id'");
echo "<option value=''>Select Part</option>";   
while($hasil = queryTable($query)){
  $selectname=$hasil['partName'];
  $selectid=$hasil['partId'];
  ?>
  <option value="<?php echo $selectid;?>"><?php echo $selectname;?></option>
  <?php
}
?>
