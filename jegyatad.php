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
	$neveredmeny=mysqli_query($link, "SELECT id, nev FROM utas");
	$jegyid=$_GET['id'];
 ?> 
<div class="container jaratform" style="border-radius: 5px; background-color: #f2f2f2; padding:20px 20px;">
	<h1 style="font-size: 20px;"> Jegy átadása </h1></br></br>
	<form method="post" action="jegyatad.php?id=<?php echo $_GET['id']; ?>">
		<label for="utas">Kihez kerül a jegy?</label>
		<select id="utas" name="utas">
			<?php while($nevrow=mysqli_fetch_array($neveredmeny)): ?>
			<option value="<?php echo $nevrow['id']; ?>"><?php echo $nevrow['nev'];?></option>
			<?php endwhile; ?>
		</select>
		<input type="submit" value="Átad" name="uj">
	</form>
</div>
<?php

if(isset($_POST['uj'])){
	if(empty($_POST['utas']))
	{
		echo "<br> Ne hagyjd üresen a mezőket!";
		return false;
	}
	
	$utasid=$_POST['utas'];
	$query="UPDATE jegy SET utasid =".$utasid." WHERE id=".mysqli_real_escape_string($link, $jegyid).";";
	
	mysqli_query($link, $query);
	mysqli_close($link);
	header("Location: jegyek.php");
}

?>
</body>
</html>