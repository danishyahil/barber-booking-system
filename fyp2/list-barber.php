<?PHP
session_start();

include("database.php");
?>
<?PHP
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_barber 	= (isset($_REQUEST['id_barber'])) ? trim($_REQUEST['id_barber']) : '';	

$date		= (isset($_POST['date'])) ? trim($_POST['date']) : '';
$slot 		= (isset($_POST['slot'])) ? trim($_POST['slot']) : '';
$location 	= (isset($_POST['location'])) ? trim($_POST['location']) : '';

$success = "";

?>
<!DOCTYPE html>
<html>
<title>BarberOnGo</title>
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

<?PHP include("navbar.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "booking-add.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>Make Appointment With Us Today!</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
		
		<div class="w3-row w3-margin ">
		<h4><b>List of Barber</b></h4>
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Photo</th>
					<th>Barber Name</th>
					<th>Address</th>
					<th>Rating</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `barber` ";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$photo		= $data["photo"];
				if(!$photo) $photo = "avatar.png";
				$bil++;
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><img src="photo/<?PHP echo $photo; ?>" class="w3-circle w3-image" alt="photo" style="width:40px;max-width:40px"></td>				
				<td><?PHP echo $data["name"] ;?></td>
				<td><?PHP echo $data["address"] ;?> <a target="_blank" href="<?PHP echo $data["gmap"] ;?>" class="w3-tag w3-blue w3-round"><i class="fa fa-fw fa-map-marker fa-lg"></i> Direction</a></td>
				<td>
				<a href="#" onclick="document.getElementById('idRate<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-red w3-round" ><i class="fa fa-fw fa-star fa-lg"></i>Rating</a>
				</td>
				<td>
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-red w3-round">View Details</a>
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

			
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Barber Details</b>
			<hr>
			  
			<div class="w3-section w3-row w3-border w3-round w3-padding " >
			  
			  <div class="w3-col s4 " >
			  
			  <img src="photo/<?PHP echo $photo; ?>" class="w3-round w3-image" alt="photo" style="width:150px;max-width:150px">
			  
			  </div>
			  
			  <div class="w3-col s8" >
				<div class="w3-margin-left">
				<b><?PHP echo $data["name"]; ?></b><br>
				<?PHP echo $data["email"]; ?><br>
				<?PHP echo $data["phone"]; ?><br>
				<?PHP echo $data["address"]; ?><br>
				<?PHP echo $data["services"]; ?>
				</div>
			  </div>
			  
			</div>
			  
			  <div class="w3-section " >
				<label>Date *</label>
				<input class="w3-input w3-border w3-round" type="date" name="date" value="" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Time *</label>
				<select class="w3-input w3-border w3-round" name="slot" value="" required>
					<option value="9.00am">9.00am</option>
					<option value="10.00am">10.00am</option>
					<option value="11.00am">11.00am</option>
					<option value="12.00pm">12.00pm</option>
					<option value="1.00pm">1.00pm</option>
				</select>
			  </div>
			  
			  <div class="w3-section " >
				<label>Services *</label>
				<select class="w3-input w3-border w3-round" name="servicestype" value="" required>
					<option value="Haircut - ET 30 Minutes">Haircut - ET 30 Minutes</option>
					<option value="Haircut and Wash - ET 1 Hour 15 Minutes">Haircut and Wash - ET 1 Hour 15 Minutes</option>
					<option value="Wash And Styling - ET 30 Minutes">Wash And Styling - ET 30 Minutes</option>
					<option value="Facial - ET 20 Minutes">Facial - ET 20 Minutes</option>
				</select>
			  </div>

			  <div class="w3-section " >
				<label>Location *</label>
				<select class="w3-input w3-border w3-round" name="location" value="" required>
					<option value="Barber Place">Barber Place</option>
					<option value="Customer Place">Customer Place</option>
				</select>
			  </div>
			   
			<hr class="w3-clear">
			<p><a href="user-login.php" class="button btn-hire">Login To Make Appointment</a></p>

		</form>
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
