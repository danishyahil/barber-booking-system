<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: admin-index.php" );
	return false;
}
?>
<?PHP	
$SQL_view 	= " SELECT * FROM `admin` WHERE `username` =  '". $_SESSION["username"] ."'";
$result 	= mysqli_query($con, $SQL_view);
$data		= mysqli_fetch_array($result);

$tot_customer 	= numRows($con, "SELECT * FROM `customer`");
$tot_barber 	= numRows($con, "SELECT * FROM `barber`");
$tot_booking 	= numRows($con, "SELECT * FROM `booking`  ");
?>
<!DOCTYPE html>
<html>
<title>Barber-On-Go</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
a { text-decoration : none ;}

body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.5;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-image: url(images/banner.jpg);
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body>

<?PHP include("admin-navbar.php"); ?>


<div class="bgimg-1" >

	<div class="w3-padding-64"></div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row">
	  

		  <div class="w3-padding w3-padding-16">
			<div class="w3-card w3-padding w3-round w3-white">
				<div class="w3-dark-gray w3-xlarge w3-padding-24 w3-padding" >
					<div class="w3-padding">Welcome, Admin</div>
				</div>
				
				<div class="w3-row w3-padding-24">
					<div class="w3-col m4 w3-container">
						<div class=" w3-card w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Customer <i class="fa fa-users fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<h2 class="w3-center"><?PHP echo $tot_customer;?></h2>
								<a href="admin-customer.php" class="w3-small w3-right w3-tag w3-round w3-red">View   &nbsp;<i class="fa fa-fw fa-chevron-right"></i></a>
							</div>
						</div>
					</div>
					
					<div class="w3-col m4 w3-container">
						<div class="w3-border w3-card w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Barber <i class="fa fa-user fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<h2 class="w3-center"><?PHP echo $tot_barber;?></h2>
								<a href="admin-barber.php" class="w3-small w3-right w3-tag w3-round w3-red">View   &nbsp;<i class="fa fa-fw fa-chevron-right"></i></a>
							</div>
						</div>
					</div>
					
					<div class="w3-col m4 w3-container">
						<div class="w3-border w3-card w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Appointment <i class="fa fa-calendar fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<h2 class="w3-center"><?PHP echo $tot_booking;?></h2>
								<a href="admin-booking.php" class="w3-small w3-right w3-tag w3-round w3-red">View   &nbsp;<i class="fa fa-fw fa-chevron-right"></i></a>
							</div>
						</div>
					</div>
					

			</div>
		  </div>
		</div>
			  

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-24"></div>
	
</div>
<?php include("footer.php"); ?>
</body>
</html>
