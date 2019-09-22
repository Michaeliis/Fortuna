<?php
$con=mysqli_connect('localhost', 'root', '', 'uas_pos');

function querySelect($query){
  global $con;
  $hello=mysqli_fetch_array(mysqli_query($con, $query));
  return $hello;
}

function queryRun($query){
  global $con;
  $hello=mysqli_query($con, $query);
  return $hello;
}

function queryTable($query){
  global $con;
  $hello=mysqli_fetch_assoc($query);
  return $hello;
}
?>
