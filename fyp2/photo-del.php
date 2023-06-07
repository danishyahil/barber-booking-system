<?php
include("database.php");

$id_barber 	= (isset($_GET['id_barber'])) ? trim($_GET['id_barber']) : '';

$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `photo` FROM `barber` WHERE `id_barber`= '$id_barber'"));

unlink("photo/" .$dat['photo']);

$rst_d = mysqli_query( $con, "UPDATE `barber` SET `photo`='' WHERE `id_barber` = '$id_barber' " );

print "<script>self.location='barber-profile.php';</script>";
?>
