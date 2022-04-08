<!doctype html>
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
	$eredmeny = mysqli_query($link, "SELECT id, nev, email, telefon, szemelyigazolvanyszam FROM utas WHERE id='".mysqli_real_escape_string($link, $_GET["id"])."';");
	$row=mysqli_fetch_array($eredmeny);
 ?> 


<div class="container jaratform" style="border-radius: 5px; background-color: #f2f2f2; padding:20px;">
	<h1 style="font-size: 20px;"> Utas módosítás </h1></br></br>
	<form method="post" action="">
		<label for="nev">Név</label>
		<input type="text" id="nev" name="nev" value="<?php echo $row["nev"]; ?>" placeholder="Név">
		
		<label for="email">Email-cím</label>
		<input type="email" id="end" name="email" value="<?php echo $row["email"]; ?>" placeholder="Email-cím">

		<label for="telefon">Telefonszám</label>
		<input type="text" id="telefon" name="telefon" value="<?php echo $row["telefon"]; ?>" placeholder="Telefonszám">

		<label for="szemig">Személyigazolványszám</label>
		<input type="text" id="szemig" name="szemig" value="<?php echo $row["szemelyigazolvanyszam"]; ?>" placeholder="Személyigazolványszám">
		
		<input type="submit" value="Módosít" name="uj">
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
	
	$query=sprintf("UPDATE utas SET nev ='".$nev."', email='".$email."', telefon='".$telefon."', szemelyigazolvanyszam='".$szemig."' WHERE id='".mysqli_real_escape_string($link, $_GET["id"])."';");
	
	mysqli_query($link, $query);
	mysqli_close($link);
	header("Location: utas.php");
}
?>
</body>
</html>