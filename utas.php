<!doctype html>
<?php 
ob_start();
// Volt egy hiba a kódomban, és egy netes videó ezt ajánlotta. Megoldotta a problémát.
?>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="bootstrap.css">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="static/img.ico" />

    <title>Info2</title>
</head>
<body>

<!-- Navigációs Menü Sor -->

<?php include 'menu.php'; ?>

<!-- Navigációs Menü Sor -->

<?php 
	include 'db.php';
	$link=opendb();
	$eredmeny=mysqli_query($link, "SELECT * from utas");	
 ?> 
 <div class="container jaratok" style="overflow-x:auto;">
 <table class="table table-bordered table-striped table-lg">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th>Név</th>
						<th>Email-cím</th>
						<th>Telefonszám</th>
						<th>Személyigazolványszám</th>
						<th>Törlés/Módosítás</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row=mysqli_fetch_array($eredmeny)):?>
					<tr>
						<td><?=$row['id']?></td>
						<td><?=$row['nev']?></td>
						<td><?=$row['email']?></td>
						<td><?=$row['telefon']?></td>
						<td><?=$row['szemelyigazolvanyszam']?></td>
						<td style="font-size: 15px font-weight: bold;"><a href="deleteember.php?id=<?=$row['id']?>"><img src="static/delete.jpg" style="height:15px; width: 15px;"></a>      /       <a href="modifyember.php?id=<?=$row['id']?>"><img src="static/modify.jpg" style="height:15px; width: 15px;"></a> </td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>		
 </div>
 <div class="container jaratform" style="border-radius: 5px; background-color: #f2f2f2; padding:20px;">
	<h1 style="font-size: 20px;"> Új felhasználó létrehozása </h1></br></br>
	<form method="post" action="utas.php">
		<label for="nev">Név</label>
		<input type="text" id="nev" name="nev" placeholder="Név">
		
		<label for="email">Email-cím</label>
		<input type="email" id="email" name="email" placeholder="Email-cím">
		
		<label for="telefon">Telefonszám</label>
		<input type="text" id="telefon" name="telefon" placeholder="Telefonszám">
		
		<label for="szemig">Személyigazolványszám</label>
		<input type="text" id="szemig" name="szemig" placeholder="Személyigazolványszám">
		
		<input type="submit" value="Létrehoz" name="uj">
	</form>
</div>
<?php
if(isset($_POST['uj'])){
	if(empty($_POST['nev']) or empty($_POST['email']) or empty($_POST['telefon']) or empty($_POST['szemig']))
	{
		echo "<br> Ne hagyjd üresen a mezőket!";
		return false;
	}
	
	$nev=$_POST['nev'];
	$email=$_POST['email'];
	$telefon=$_POST['telefon'];
	$szemig=$_POST['szemig'];
	
	$query=sprintf("INSERT INTO utas(nev, email, telefon, szemelyigazolvanyszam) VALUES ('%s','%s','%s','%s')",mysqli_real_escape_string($link, $nev), mysqli_real_escape_string($link, $email), mysqli_real_escape_string($link, $telefon),mysqli_real_escape_string($link, $szemig)); 
	
	mysqli_query($link, $query);
	mysqli_close($link);
	header("Location: utas.php");
	ob_enf_flush(); // Ez a .php fájl elején említett hiba megoldására van
	
}
?>
</body>
</html>