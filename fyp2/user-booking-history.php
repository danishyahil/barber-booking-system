<?PHP
session_start();

include("database.php");
if( !verifyCustomer($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_barber 	= (isset($_REQUEST['id_barber'])) ? trim($_REQUEST['id_barber']) : '';	

$date		= (isset($_POST['date'])) ? trim($_POST['date']) : '';
$slot 		= (isset($_POST['slot'])) ? trim($_POST['slot']) : '';
$services 	= (isset($_POST['services'])) ? trim($_POST['services']) : '';
$location 	= (isset($_POST['location'])) ? trim($_POST['location']) : '';

$success = "";

$rating 	= (isset($_POST['rating'])) ? trim($_POST['rating']) : '';
$comment 	= (isset($_POST['comment'])) ? trim($_POST['comment']) : '';


if($act == "addRating")
{	
	$SQL_insert = " 
	INSERT INTO `rating`(`id_rating`, `id_barber`, `rating`, `comment`, `username`) 
	VALUES (NULL,'$id_barber','$rating','$comment', '". $_SESSION["username"] ."')
	";	
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Success Add Rating";
	
}

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

<?PHP include("user-navbar.php"); ?>
<?PHP if($success) { ?>
<div class="w3-panel w3-green w3-display-container w3-animate-zoom">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  <h3>Success!</h3>
  <p>Your rating was successful added!</a> </p>
</div>
<?PHP  } ?>	

<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>Appointment History</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
		
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Time</th>
					<th>Barber</th>
					<th>Services</th>
					<th>Location</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `booking`,`barber` WHERE booking.id_barber = barber.id_barber AND id_customer = " .$_SESSION["id_customer"]. " ";
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
				<td><?PHP echo $data["servicestype"] ;?>
				<?PHP if($data["servicestype"]) { ?>
					<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class="w3-tag w3-blue w3-round">Detail Prices</a>
				<?PHP } ?>
				</td>
				<td><?PHP echo $data["location"] ;?></td>
				<td>
				<a href="#" onclick="document.getElementById('idRate<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-red w3-round">Rate Now</a>
				</td>
			</tr>

			<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Price Details</b>
			<hr>
			  
			<div class="w3-section w3-row w3-border w3-round w3-padding " >
			  
			  
			  <div class="w3-col s8" >
				<div class="w3-margin-left">
				<b><?PHP echo $data["name"]; ?></b><br>
				<?PHP echo $data["services"]; ?>
				</div>
			  </div>
			  
			</div>

		</form>
		</div>
	</div>
</div>
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
			<button class="w3-bar-item w3-button tablink<?PHP echo $bil; ?>" onclick="openCity<?PHP echo $bil; ?>(event,'Paris<?PHP echo $bil; ?>')">Submit Rating</button>
		</div>
		
		
		

		<div id="Paris<?PHP echo $bil; ?>" class="w3-container w3-border city<?PHP echo $bil; ?>" style="display:none">
			<p></p>
			<b>Submit Rating</b>
			<p>
			
			<form action="" method="post" >

				  
				<div class="w3-section " >
					<label>Rating *</label>
					<select class="w3-input w3-border w3-round" name="rating" value="" required>
						<option value="1">1 star</option>
						<option value="2">2 star</option>
						<option value="3">3 star</option>
						<option value="4">4 star</option>
						<option value="5">5 star</option>
					</select>
				</div>
				
				<div class="w3-section " >
					<label>Comment *</label>
					<textarea class="w3-input w3-border w3-round" rows="4" name="comment" value="" required></textarea>
				</div>
				  
				  
				   
				<hr class="w3-clear">
				<input type="hidden" name="id_barber" value="<?PHP echo $data["id_barber"];?>" >
				<input type="hidden" name="act" value="addRating" >
				<button type="submit" class="w3-button w3-wide w3-red w3-text-white w3-margin-bottom w3-round">SUBMIT RATING</button>

			</form>
			
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

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-64"></div>
	
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
<?php include("footer.php"); ?>
</body>
</html>
