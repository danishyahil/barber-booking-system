<?PHP
session_start();

include("database.php");
if( !verifyBarber($con) ) 
{
	header( "Location: barber-booking-history.php" );
	return false;
}
?>
<?PHP	
$SQL_view 	= " SELECT * FROM `barber` WHERE `username` =  '". $_SESSION["username"] ."'";
$result 	= mysqli_query($con, $SQL_view);
$data		= mysqli_fetch_array($result);


$rating 	= (isset($_POST['rating'])) ? trim($_POST['rating']) : '';
$comment 	= (isset($_POST['comment'])) ? trim($_POST['comment']) : '';

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


<div class="bgimg-1 w3-light-gray" >

	<div class="w3-padding-64"></div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row">
	  

		<div class="w3-padding w3-padding-16">
			<div class="w3-card w3-padding w3-round w3-white">
				<div class="w3-dark-gray w3-xlarge w3-padding-24 w3-padding" >
					<div class="w3-padding">All Appointment History</div>
				</div>
				
				<div class="w3-row w3-padding-24">
                
				
				<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Time</th>
							<th>Customer</th>
							<th>Services</th>
							<th>Location</th>
							<th></th>
							
                            
						</tr>
					</thead>
					<tbody>
					<?PHP
					$bil = 0;
					$SQL_list = "SELECT * FROM `booking`,`customer` WHERE booking.id_customer = customer.id_customer AND id_barber = " .$_SESSION["id_barber"]. " ";
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
						<td><?PHP echo $data["servicestype"] ;?></td>
						<td><?PHP echo $data["location"] ;?></td>
						<td>
				<a href="#" onclick="document.getElementById('idRate<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-red w3-round"><i class="fa fa-fw fa-star fa-lg"></i>All Rating</a>
				</td>
						
					</tr>
					<div id="idRate<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idRate<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<div class="w3-padding"></div>
			<b class="w3-large">Rating & Comment</b>
			<hr>
			
			
		<div class="w3-bar w3-white">
			<button class="w3-bar-item w3-button tablink<?PHP echo $bil; ?> w3-red" onclick="openCity<?PHP echo $bil; ?>(event,'London<?PHP echo $bil; ?>')">All Rating</button>
			
		</div>
		
		
		<div id="London<?PHP echo $bil; ?>" class="w3-container w3-border city<?PHP echo $bil; ?>">
			<p></p>
			<b>All Rating</b>
			<p>
			<ul class="w3-ul w3-border">
				<?PHP
				$star = "★";
				$sql_rating = "SELECT * FROM `rating` WHERE id_barber = " . $data["id_barber"];
				$rst_rating = mysqli_query($con, $sql_rating) ;
				$found = mysqli_num_rows($rst_rating);
				while ( $dat_rating	= mysqli_fetch_array($rst_rating) )
				{
					if($dat_rating["rating"] == "1") $star = "★";
					if($dat_rating["rating"] == "2") $star = "★★";
					if($dat_rating["rating"] == "3") $star = "★★★";
					if($dat_rating["rating"] == "4") $star = "★★★★";
					if($dat_rating["rating"] == "5") $star = "★★★★★";
				?>		
				<li><b><?PHP echo $dat_rating["username"] . " (" . $star . ")"; ?> </b><p class="w3-padding w3-light-gray w3-round"><?PHP echo $dat_rating["comment"];?></p></li>
				<?PHP 
				}
				if($found == 0) echo "- No Rating yet -";
				?>
			</ul>
			</p>
		</div>

		
  
		<script>
		function openCity<?PHP echo $bil; ?>(evt, cityName<?PHP echo $bil; ?>) {
		  var i, x, tablinks;
		  x = document.getElementsByClassName("city<?PHP echo $bil; ?>");
		  for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablink<?PHP echo $bil; ?>");
		  for (i = 0; i < x.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
		  }
		  document.getElementById(cityName<?PHP echo $bil; ?>).style.display = "block";
		  evt.currentTarget.className += " w3-red";
		}
		</script>
  
		
		</div>
	</div>
</div>	
					
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
