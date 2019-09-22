<?php include('koneksi.php');

function none(){
  global $con;
  $query=queryRun("SELECT supply.supplyId, supplierId, supplyDate, suppname, partName, supplyQuantity, supplyPrice FROM supplier, part, supply, supplydet WHERE supplydetstatus=1 AND supplydet.partId=part.partId AND supplierid=suppid AND supplydet.supplyId=supply.supplyId;");
    ?>
    <thead>
          <tr>
            <th>Supply ID</th>
            <th>Part Name</th>
            <th>Supplier</th>
            <th>Date</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Price Total</th>
          </tr>
        </thead>
    <?php
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
  global $con;
  $query=queryRun("SELECT supply.supplyId, supply.supplyDate, supplier.suppName, SUM(supplydet.supplyQuantity*supplydet.supplyPrice) AS 'total' FROM supply, supplydet, supplier WHERE supply.supplyId=supplydet.supplyId AND supply.supplyStatus=1 AND supplier.suppId=supply.supplierId GROUP BY supply.supplyId");
    ?>
    <thead>
          <tr>
            <th>Supply ID</th>
            <th>Supplier</th>
            <th>Date</th>
            <th>Price Total</th>
            <th>Info</th>
          </tr>
        </thead>
    <?php
  while($hasil=queryTable($query)){
    $supplyid=$hasil['supplyId'];
    $suppliername=$hasil['suppName'];
    $supplydate=$hasil['supplyDate'];
    $price=$hasil['total'];
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
          <a href="purchasedetail.php?id=<?php echo $supplyid?>" class="btn btn-info">Detail</a>
      </td>
    </tr>
    <?php
  }
}
    
$group=$_POST['group'];
switch($group){
    case 'none':
        none();
        break;
    case 'group':
        group();
        break;
}
        