<?php 
session_start();
if(isset($_SESSION['myname'])){
  unset($_SESSION['myname']);
}
if (isset($_SESSION['imei'])){
  unset($_SESSION['imei']);
}
echo "<script>window.location = '../../index.php'</script>";
?>