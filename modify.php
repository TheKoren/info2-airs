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
	$eredmeny = mysqli_query($link, "SELECT id, honnan, hova, maxkapacitas, tipus, ar FROM jarat WHERE id='".mysqli_real_escape_string($link, $_GET["id"])."';");
	$row=mysqli_fetch_array($eredmeny);
 ?> 

<div class="container jaratform" style="border-radius: 5px; background-color: #f2f2f2; padding:20px;">
	<h1 style="font-size: 20px;"> Járat módosítás </h1></br></br>
	<form method="post" action="">
		<label for="start">Induális pont</label>
		<input type="text" id="start" name="start" value="<?php echo $row["honnan"]; ?>" placeholder="Ahonnan a gép elindul..">
		
		<label for="end">Érkezési hely</label>
		<input type="text" id="end" name="end" value="<?php echo $row["hova"]; ?>" placeholder="Ahova a gép érkezik..">
		
		<label for="tipus">Járattípusa</label>
		
		<select id="tipus" name="tipus">
			<option <?php if($row["tipus"]=="Boeing-42"){ echo "selected='selected'";} ?> value="Boeing-42">Boeing</option>
			<option <?php if($row["tipus"]=="Dodo"){ echo "selected='selected'";} ?> value="Dodo">Dodo</option>
			<option <?php if($row["tipus"]=="Ripazha"){ echo "selected='selected'";} ?> value="Ripazha">Ripazha</option>
		</select>
		<label for="ar">Ár</label>
		<input type="number" id="ar" name="ar" value="<?php echo $row["ar"]; ?>" placeholder="Út ára..">
		
		<input type="submit" value="Módosít" name="uj">
	</form>
</div>
</body>
</html>
<?php
if(isset($_POST['uj'])){
	if(empty($_POST['start']) or empty($_POST['end']) or empty($_POST['tipus']) or empty($_POST['ar']))
	{
		echo "<br> Ne hagyjd üresen a mezőket!";
		return false;
	}
	$start=$_POST['start'];
	$end=$_POST['end'];
	$tipus=$_POST['tipus'];
	$ar=$_POST['ar'];
	$maxkapacitas;
	if(strcmp($tipus,"Dodo")==0)
	{
		$maxkapacitas='2';
	}
	elseif(strcmp($tipus,"Ripazha")==0)
	{
		$maxkapacitas='3';
	}
	elseif(strcmp($tipus,"Boeing-42")==0)
	{
		$maxkapacitas='5';
	}
	else
	{
		echo "<br> Baj van";
	}
	$query=sprintf("UPDATE jarat SET honnan ='".$start."', hova='".$end."', tipus='".$tipus."', ar='".$ar."', maxkapacitas='".$maxkapacitas."' WHERE id='".mysqli_real_escape_string($link, $_GET["id"])."';");
	
	mysqli_query($link, $query);
	mysqli_close($link);
	header("Location: jarat.php");
}

?>