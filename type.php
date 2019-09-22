<?php
include("koneksi.php");
$id=$_POST['partt'];
$query=queryRun("SELECT * FROM part WHERE partType=$id AND partStatus=1");
echo "<option value=''>Select Part</option>";   
while($hasil = queryTable($query)){
  $selectname=$hasil['partName'];
  $selectid=$hasil['partId'];
  ?>
  <option value="<?php echo $selectid;?>"><?php echo $selectname;?></option>
  <?php
}
?>
