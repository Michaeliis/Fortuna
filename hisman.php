<?php
include("koneksi.php");
$group=$_POST['group'];

switch($group){
    case 'group':
        $query=queryRun("SELECT production.prodId, branch.braName, production.prodStart FROM production, branch WHERE production.braId=branch.braId AND prodStatus=2");
        ?>
        <thead>
            <tr>
                <th>Production ID</th>
                <th>Branch</th>
                <th>Date Start</th>
                <th>Info</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($hasil = queryTable($query)){
            $prodid=$hasil['prodId'];
            $branch=$hasil['braName'];
            $start=$hasil['prodStart'];
            ?>
            <tr>
                <td><?php echo $prodid?></td>
                <td><?php echo $branch?></td>
                <td><?php echo $start?></td>
                <td><a href="mandetail.php?id=<?php echo $prodid?>" class="btn btn-info">Detail</a>
            </tr>
            <?php
        }?>
        </tbody>
        <?php
    break;
        
    case 'none':
        $query=queryRun("SELECT productiondet.prodId, production.braId, productiondet.carId, card.cardName, prodStart, prodDetFinish, prodDetStatus, braName, productiondet.prodDetCost FROM production, branch, productiondet, car, card WHERE production.braId=branch.braId AND productiondet.prodId=production.prodId AND productiondet.carId=car.carId AND car.cardId=card.cardId");
        ?>
        <thead>
            <tr>
                <th>Production ID</th>
                <th>Branch</th>
                <th>Car Id</th>
                <th>Car Name</th>
                <th>Date Start</th>
                <th>Date Finish</th>
                <th>Status</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($hasil = queryTable($query)){
            $prodid=$hasil['prodId'];
            $cost=$hasil['prodDetCost'];
            $branch=$hasil['braName'];
            $carid=$hasil['carId'];
            $card=$hasil['cardName'];
            $start=$hasil['prodStart'];
            $finish=$hasil['prodDetFinish'];
            $status=$hasil['prodDetStatus'];
            $statuss="";
            if($status==1){
                $statuss="Done";
            }else if($status==2){
                $statuss="In Process";
            }else if($status==0){
                $statuss="Cancelled";
            }
            ?>
            <tr>
                <td><?php echo $prodid?></td>
                <td><?php echo $branch?></td>
                <td><?php echo $carid?></td>
                <td><?php echo $card?></td>
                <td><?php echo $start?></td>
                <td><?php echo $finish?></td>
                <td><?php echo $statuss?></td>
                <td><?php echo $cost?></td>
            </tr>
            <?php
        }?>
        </tbody>
        <?php
    break;
}