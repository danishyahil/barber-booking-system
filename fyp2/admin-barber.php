<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_barber 	= (isset($_REQUEST['id_barber'])) ? trim($_REQUEST['id_barber']) : '';	

$username	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$name 		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$address 	= (isset($_POST['address'])) ? trim($_POST['address']) : ''; 
$gmap 		= (isset($_POST['gmap'])) ? trim($_POST['gmap']) : '';
$services 		= (isset($_POST['services'])) ? trim($_POST['services']) : '';

$success = "";

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `barber`(`id_barber`, `username`, `password`, `name`, `email`, `phone`, `address`, `gmap`, `services`, `created_date`) VALUES (NULL, '$username', '$password', '$name', '$email', '$phone', '$address', '$gmap', '$services', NOW() )
	";	
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Success Register";
	
	
}


if($act == "edit")
{	
	$SQL_update = " UPDATE `barber` SET 
						`username` = '$username',
						`password` = '$password',
						`name` = '$name',
						`email` = '$email',
						`phone` = '$phone',
						`address` = '$address',
                        `gmap` = '$gmap',
						`services` = '$services'
					WHERE `id_barber` =  '$id_barber'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	
	$success = "Successfully Update";
	
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `barber` WHERE `id_barber` =  '$id_barber' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Success Delete";
	
}

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

<?PHP include("admin-navbar.php"); ?>

<!--- Toast Notification -->
<?PHP if($success) { ?>
<div class="w3-panel w3-green w3-display-container w3-animate-zoom">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  <h3>Success!</h3>
  <p>Successful updated!</a> </p>
</div>
<?PHP  } ?>		

<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>Barber List</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">

		<a onclick="document.getElementById('add01').style.display='block'; " class=" w3-right w3-button w3-red w3-margin-bottom w3-round "><i class="fa fa-fw fa-lg fa-plus"></i> Add</a>
		
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Username</th>
					<th>Password</th>
					<th>Phone</th>
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
				$bil++;
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>	
				<td><?PHP echo $data["name"] ;?></td>
				<td><?PHP echo $data["email"] ;?></td>
				<td><?PHP echo $data["username"] ;?></td>
				<td><?PHP echo $data["password"] ;?></td>
				<td><?PHP echo $data["phone"] ;?></td>
				<td>
				<a href="#" onclick="document.getElementById('idRate<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-red w3-round"><i class="fa fa-fw fa-star fa-lg"></i>Rating</a>
				</td>
				<td>
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-fw fa-pencil-square-o fa-lg"></i></a>
				
				<a title="Delete" onclick="return confirm('Are you sure ?');" href="?act=del&id_barber=<?PHP echo $data["id_barber"]; ?>" class=" w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>
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
			<b class="w3-large">Update</b>
			<hr>
			  <div class="w3-section " >
				<label>Name *</label>
				<input class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $data["name"]; ?>" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Email *</label>
				<input class="w3-input w3-border w3-round" type="email" name="email" value="<?PHP echo $data["email"]; ?>" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Mobile Phone *</label>
				<input class="w3-input w3-border w3-round" type="text" name="phone" value="<?PHP echo $data["phone"]; ?>" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Address *</label>
				<textarea class="w3-input w3-border w3-round" name="address" required><?PHP echo $data["address"]; ?></textarea>
			  </div>
			  
			  <div class="w3-section">
				<label>Google Map Url </label>
				<input class="w3-input w3-border w3-round" type="text" name="gmap" value="<?PHP echo $data["gmap"]; ?>" >
			  </div>

			  <div class="w3-section">
				<label>Services *</label>
				<textarea class="w3-input w3-border w3-round" name="services" required><?PHP echo $data["services"]; ?></textarea>
			  </div>
			  
			  <div class="w3-section " >
				<label>Username *</label>
				<input class="w3-input w3-border w3-round" type="text" name="username" value="<?PHP echo $data["username"]; ?>" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Password  *</label>
				<input class="w3-input w3-border w3-round" type="password" name="password" value="<?PHP echo $data["password"]; ?>" required>
			  </div>
			  
			<hr class="w3-clear">
			<input type="hidden" name="id_barber" value="<?PHP echo $data["id_barber"];?>" >
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-wide w3-red w3-text-white w3-margin-bottom w3-round">SAVE CHANGES</button>

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

<div id="add01" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('add01').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>
	  
      <div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Add Barber</b>
			<hr>
			  <div class="w3-section" >
				<label>Full Name *</label>
				<input class="w3-input w3-border w3-round" type="text" name="name"  required>
			  </div>
			  
			  <div class="w3-section">
				<label>Email *</label>
				<input class="w3-input w3-border w3-round" type="email" name="email" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Mobile Phone *</label>
				<input class="w3-input w3-border w3-round" type="text" name="phone" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Address *</label>
				<textarea class="w3-input w3-border w3-round" name="address" required></textarea>
			  </div>

			  <div class="w3-section">
				<label>Google Map Url </label>
				<input class="w3-input w3-border w3-round" type="text" name="gmap" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Services *</label>
				<textarea class="w3-input w3-border w3-round" name="services" required></textarea>
			  </div>

			  <div class="w3-section">
				<label>Username *</label>
				<input class="w3-input w3-border w3-round" type="text" name="username" required>
			  </div>
			  
			  <div class="w3-section">
				<label>Password *</label>
				<input class="w3-input w3-border w3-round" type="password" name="password" required>
			  </div>
			  
			  <hr class="w3-clear">
			  
			  <div class="w3-section" >
				<input name="act" type="hidden" value="add">
				<button type="submit" class="w3-button w3-wide w3-red w3-text-white w3-margin-bottom w3-round">SUBMIT</button>
			  </div>
			</div>  
		</form> 
         
      </div>

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
