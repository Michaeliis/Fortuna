 <?php include("koneksi.php");
$cardId=$_POST['cardId'];
$query=queryRun("SELECT carpart.cardId, carpart.partId, part.partType, parttLimit FROM carpart, parttype, part WHERE carpart.partId=part.partId AND part.partType=parttId AND cardId='$cardId'");
$ready=true;
$misPart=array();
$misQuan=array();
$misPrice=array();
while($hasil=queryTable($query)){
    $partId=$hasil['partId'];
    $parttLimit=$hasil['parttLimit'];
    $need=$parttLimit*$quantity;
    $check=querySelect("SELECT partQuantity, partPrice FROM part WHERE part.partId='$partId'");
    $stock=$check['partQuantity'];
    $price=$check['partPrice'];
    if($stock<$quantity){
        array_push($misPart, $partId);
        array_push($misQuan, ($stock-$need));
        array_push($misPrice, $price);
    }
}
$empId=$_POST['empId'];
$date=date("Y-m-d");
global $empId;
for($i=0; $i<count($misPart); $i++){
    $part=$misPart[$i];
    $quan=$misQuan[$i];
    $price=$misPrice[$i];
    if(!$hello['there']){
      $suppId='01'.date("Ymd")."001";
    }else{
      $suppId='01'.date("Ymd").sprintf("%03d", substr($hello['there'], -3)+1);
    }
    $hasil=querySelect("SELECT supplierId FROM supplierdet WHERE partId='$part' AND sDetStatus=1");
    $supplierId=$hasil['supplierId'];
    queryRun("INSERT INTO supply VALUES('$suppId', '$supplierId', '$empId', '$date', 1");
    queryRun("INSERT INTO supplydet VALUES('$suppId', '$part', '$quan', '$price', 1");
    queryRun("UPDATE part SET partQuantity = 0 WHERE `part`.`partId` = $part");
}
?>