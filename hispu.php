<?php include("koneksi.php");
$group=$_POST['group'];

function none(){
    $query=queryRun("SELECT supply.supplyId, supplierId, supplyDate, suppname, partName, supplyQuantity, supplyPrice FROM supplier, part, supply, supplydet WHERE supplydetstatus=1 AND supplydet.partId=part.partId AND supplierid=suppid AND supplydet.supplyId=supply.supplyId;");
    while($hasil=queryTable($query)){
        $supplyid=$hasil['supplyId'];
        $suppliername=$hasil['suppname'];
        $supplydate=$hasil['supplyDate'];
        $partname=$hasil['partName'];
        $quantity=$hasil['supplyQuantity'];
        $price=$hasil['supplyPrice'];
        $pricetotal=$price*$quantity;
        ?>
        <tr>
          <td>
            <?php echo $supplyid?>
          </td>
          <td>
            <?php echo $partname?>
          </td>
          <td>
            <?php echo $suppliername?>
          </td>
          <td>
            <?php echo $supplydate?>
          </td>
          <td>
            <?php echo $price?>
          </td>
          <td>
            <?php echo $quantity?>
          </td>
          <td>
            <?php echo $pricetotal?>
          </td>
        </tr>
        <?php
      }
}

function group(){
    $query=queryRun("SELECT supply.supplyId, supplierId, supplyDate, suppname, partName, supplyQuantity, supplyPrice FROM supplier, part, supply, supplydet WHERE supplydetstatus=1 AND supplydet.partId=part.partId AND supplierid=suppid AND supplydet.supplyId=supply.supplyId AND supplydet.supplyId=supply.supplyId;");
    while($hasil=queryTable($query)){
        $supplyid=$hasil['supplyId'];
        $suppliername=$hasil['suppname'];
        $supplydate=$hasil['supplyDate'];
        $partname=$hasil['partName'];
        $quantity=$hasil['supplyQuantity'];
        $price=$hasil['supplyPrice'];
        $pricetotal=$price*$quantity;
        ?>
        <tr>
          <td>
            <?php echo $supplyid?>
          </td>
          <td>
            <?php echo $suppliername?>
          </td>
          <td>
            <?php echo $supplydate?>
          </td>
          <td>
            <?php echo $price?>
          </td>
          <td>
            <?php echo $quantity?>
          </td>
          <td>
            <?php echo $pricetotal?>
          </td>
        </tr>
        <?php
      }
}

switch($group){
    case 'none':
        none();
        break;
    case 'group':
        group();
        break;
}