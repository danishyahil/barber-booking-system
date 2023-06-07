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
$id_customer = (isset($_REQUEST['id_customer'])) ? trim($_REQUEST['id_customer']) : '';	

$username	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$name 		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$address 	= (isset($_POST['address'])) ? trim($_POST['address']) : ''; 
$gmap 		= (isset($_POST['gmap'])) ? trim($_POST['gmap']) : '';

$success = "";

if($act == "edit")
{	
	$SQL_update = " UPDATE `customer` SET 
						`username` = '$username',
						`password` = '$password',
						`name` = '$name',
						`email` = '$email',
						`phone` = '$phone',
						`address` = '$address',
						`gmap` = '$gmap'
					WHERE `id_customer` =  '$id_customer'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Updated Successfully";
	
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `customer` WHERE `id_customer` =  '$id_customer' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Success Delete";
	
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
		<span class="w3-xlarge"><b>User List</b></span><br>
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
					<th>Name</th>
					<th>Email</th>
					<th>Username</th>
					<th>Password</th>
					<th>Phone</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `customer` ";
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
				<td><?PHP echo $data["phone"] ;?>
				<td>
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-fw fa-pencil-square-o fa-lg"></i></a>
				
				<a title="Delete" onclick="return confirm('Are you sure ?');" href="?act=del&id_customer=<?PHP echo $data["id_customer"]; ?>" class=" w3-text-red"><i class="fa fa-fw fa-trash fa-lg"></i></a>
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
			  
			  <div class="w3-section " >
				<label>Username *</label>
				<input class="w3-input w3-border w3-round" type="text" name="username" value="<?PHP echo $data["username"]; ?>" required>
			  </div>
			  
			  <div class="w3-section " >
				<label>Password  *</label>
				<input class="w3-input w3-border w3-round" type="password" name="password" value="<?PHP echo $data["password"]; ?>" required>
			  </div>
			  
			<hr class="w3-clear">
			<input type="hidden" name="id_customer" value="<?PHP echo $data["id_customer"];?>" >
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
