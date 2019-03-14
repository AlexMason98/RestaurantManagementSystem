<!-- Header -->
<?php
include_once '../../Header.php';
?>
<!-- Header -->
<head>
<style>
	table, td, th {
  		border: 1px solid black;
}

	table {
 		 border-collapse: collapse;
  		 width: 100%;
}

	th {
  		height: 50px;
}
	table {
  		background-color: white;
 	 	color: black;
}
	table{
		margin:20px;
}
</style>
</head>

<body>
<table>
  	<tr>
    		<th>Order</th>
    		<th>Time</th>
    		<th>Status</th>
  	</tr>
  	<tr>
    		<td> </td>
    		<td> </td>
    		<td> </td>
  	</tr>
  	<tr>
    		<td> </td>
    		<td> </td>
    		<td> </td>
  	</tr>
  	<tr>
    		<td> </td>
    		<td> </td>
    		<td> </td>
  	</tr>
  	<tr>
    		<td> </td>
    		<td> </td>
    		<td> </td>
  	</tr>
</table>
<section>
		<div class="container" id="MainContainer">
			<div class="row">
				<div class="col-lg-9 col-md-8 col-sm-7">
					<table class="table table-striped table-bordered-less header">
						<thead class="thead-light">
					
						</thead>
						<?php
							include_once '../../Connections/ConnectionStaff.php';
							$sql = "SELECT Time, Items FROM Orders";
							$res = $conn->query($sql);
							if($res-> num_rows == 0){
								echo "0 results";
							}
							else{
								while($row = mysqli_fetch_assoc($res)){
									echo "<tr><td>{$row['Items']}</td>\n";
									echo "<td>{$row['Time']}</td></tr>\n";
									echo "<td>{$row['Status']}</td></tr>\n";
								}
							}
							mysqli_close($conn);
							?>

					
				</div>
			</div>
		</div>

</section>
</body>



</body>
</html>
