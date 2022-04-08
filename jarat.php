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
 ?> 


<div class="container jaratok" style="overflow-x:auto;">
			<h1 style="font-size: 45px;"> Aktuális Járataink </h1>
			<p style="font-size: 25px;"> Járataink a szélsőséges időjárás és a járványügyi helyzetre való tekintettel gyakran változhatnak </p>
			<form id="srchjarat" method="get" class="form-inline" action="jarat.php">
				<label for="kereses">Hova szeretnél eljutni?</label>
				<input type="text" class="form-control" name="kereses" id="kereses">
				<input type="submit" value="Keresés indítása" name="submit"></input>
				<?php 
					if(isset($_GET["submit"])){
						$eredmeny=mysqli_query($link, "SELECT id, honnan, hova, maxkapacitas, tipus, ar FROM jarat WHERE hova LIKE '%".mysqli_real_escape_string($link,$_GET["kereses"])."%';");
					}
					else{ //Azaz nincs semmi feltétel megadva
						$eredmeny = mysqli_query($link, "SELECT id, honnan, hova, maxkapacitas, tipus, ar FROM jarat");
					}
				?>
			</form>
			<table class="table table-bordered table-striped table-lg">
				<thead class="thead-dark">
					<tr>
						<th>Járatszám</th>
						<th>Honnan</th>
						<th>Hova</th>
						<th>Maxkapacitas</th>
						<th>Tipus</th>
						<th>Ar</th>
						<th>Törlés/Módosítás</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row=mysqli_fetch_array($eredmeny)):?>
					<tr>
						<td><?=$row['id']?></td>
						<td><?=$row['honnan']?></td>
						<td><?=$row['hova']?></td>
						<td><?=$row['maxkapacitas']?></td>
						<td><?=$row['tipus']?></td>
						<td><?=$row['ar']?></td>
						<td style="font-size: 15px font-weight: bold;"><a href="delete.php?id=<?=$row['id']?>"><img src="static/delete.jpg" style="height:15px; width: 15px;"></a>      /       <a href="modify.php?id=<?=$row['id']?>"><img src="static/modify.jpg" style="height:15px; width: 15px;"></a> </td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>		
</div>
</br>
</br>
<div class="container jaratform" style="border-radius: 5px; background-color: #f2f2f2; padding:20px;">
	<h1 style="font-size: 20px;"> Új járat létrehozása </h1></br></br>
	<form method="post" action="jarat.php">
		<label for="start">Induális pont</label>
		<input type="text" id="start" name="start" placeholder="Ahonnan a gép elindul..">
		
		<label for="end">Érkezési hely</label>
		<input type="text" id="end" name="end" placeholder="Ahova a gép érkezik..">
		
		<label for="tipus">Járattípusa</label>
		<select id="tipus" name="tipus">
			<option value="Boeing-42">Boeing</option>
			<option value="Dodo">Dodo</option>
			<option value="Ripazha">Ripazha</option>
		</select>
		
		<label for="ar">Ár</label>
		<input type="number" id="ar" name="ar" placeholder="Út ára..">
		
		<input type="submit" value="Létrehoz" name="uj">
	</form>
</div>

<?php

if(isset($_POST['uj'])){
	if(empty($_POST['start']) or empty($_POST['end']) or empty($_POST['tipus']) or empty($_POST['ar']))
	{
		echo "<br> Ne hagyjd üresen a mezőket!";
		return false;
	}
	
	$link=opendb();
	$start=$_POST['start'];
	$end=$_POST['end'];
	$tipus=$_POST['tipus'];
	$ar=$_POST['ar'];
	$maxkapacitas;
	
	// A repülőtípusok hardcode-olva vannak, mert nincs külön repülő táblám. A kapacitások nyílván repülőhöz tartoznak.
	
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
	
	
	$query=sprintf("INSERT INTO jarat(honnan, hova, maxkapacitas, tipus,ar) VALUES ('%s','%s','%d','%s','%d')",mysqli_real_escape_string($link, $start), mysqli_real_escape_string($link, $end), mysqli_real_escape_string($link, $maxkapacitas),mysqli_real_escape_string($link, $tipus), mysqli_real_escape_string($link, $ar)); 
	
	mysqli_query($link, $query);
	mysqli_close($link);
	header("Location: jarat.php");
}

?>
</body>
</html>