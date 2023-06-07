<?PHP
session_start();

include("database.php");
if( !verifyBarber($con) ) 
{
	header( "Location: barber-view-booking.php" );
	return false;
}
?>
<?PHP
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_booking = (isset($_REQUEST['id_booking'])) ? trim($_REQUEST['id_booking']) : '';	

$success = "";

if($act == "complete")
{
	$SQL_done = " UPDATE `booking` SET `status` =  1 WHERE `id_booking` =  '$id_booking' ";
	$result = mysqli_query($con, $SQL_done);
	
	$success = "Success Update";
}

$SQL_view 	= " SELECT * FROM `barber` WHERE `username` =  '". $_SESSION["username"] ."'";
$result 	= mysqli_query($con, $SQL_view);
$data		= mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<title>Barber-On-Go</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

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
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body>

<?PHP include("barber-navbar.php"); ?>
<?PHP if($success) { ?>
<div class="w3-panel w3-green w3-display-container w3-animate-zoom">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  <h3>Success!</h3>
  <p>Haircut service was successful done!</a> </p>
</div>
<?PHP  } ?>	

<div class="bgimg-1 w3-light-gray" >

	<div class="w3-padding-64"></div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row">
	  

		<div class="w3-padding w3-padding-16">
			<div class="w3-card w3-padding w3-round w3-white">
				<div class="w3-dark-gray w3-xlarge w3-padding-24 w3-padding" >
					<div class="w3-padding">Booked Appointment
					<a title="Mark as completed"  href="barber-booking-history.php"></a>
					</div>
				</div>
				
				<div class="w3-row w3-padding-24">
				
				<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Time</th>
							<th>Customer Name</th>
							<th>Phone No.</th>
							<th>Services</th>
							<th>Location</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?PHP
					$bil = 0;
					$SQL_list = "SELECT * FROM `booking`,`customer` WHERE `status` = 0 AND booking.id_customer = customer.id_customer AND id_barber = " .$_SESSION["id_barber"]. " ";
					$result = mysqli_query($con, $SQL_list) ;
					while ( $data	= mysqli_fetch_array($result) )
					{
						$bil++;
					?>			
					<tr>
						<td><?PHP echo $bil ;?></td>	
						<td><?PHP echo $data["date"] ;?></td>
						<td><?PHP echo $data["slot"] ;?></td>
						<td><?PHP echo $data["name"] ;?></td>
						<td><?PHP echo $data["phone"] ;?></td>
						<td><?PHP echo $data["servicestype"] ;?></td>
						<td><?PHP echo $data["location"] ;?>
						<?PHP if($data["location"] == "Customer Place") { ?>
                            <a target="_blank" href="<?PHP echo $data["gmap"]; ?>" class="w3-button w3-blue w3-round"><i class="fa fa-fw fa-map-marker fa-lg"></i>  Direction</a>
						<?PHP } ?>
						</td>
						<td>
						<a title="Mark as completed"  href="?act=complete&id_booking=<?PHP echo $data["id_booking"]; ?>" class=" w3-button w3-red w3-round">Done Service</a>
						</td>
					</tr>
					
					
					<?PHP } ?>
					</tbody>
				</table>
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


<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<!--<script src="assets/demo/datatables-demo.js"></script>-->

<script>
$(document).ready(function() {

  
	$('#dataTable').DataTable( {
		paging: true,
		
		searching: true
	} );
		
	
});
</script>
<?PHP include("footer.php"); ?>

</body>
</html>
