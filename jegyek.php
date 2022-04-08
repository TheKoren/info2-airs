<!doctype html>
<?php 
//ob_start();
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

<?php include 'menu.php'; ?>
<?php 
	include 'db.php';
	$link=opendb();
	$eredmeny=mysqli_query($link, "SELECT jegy.id, utas.nev, honnan, hova, tipus, ar, vasardatum FROM jarat JOIN jegy ON jarat.id=jaratid JOIN utas ON utas.id=utasid;");
 ?> 
 <div class="container jaratok" style="overflow-x:auto;">
 <table class="table table-bordered table-striped table-lg">
				<thead class="thead-dark">
					<tr>
						<th>Jegy Azonosító</th>
						<th>Név</th>
						<th>Honnan</th>
						<th>Hova</th>
						<th>Típus</th>
						<th>Ár</th>
						<th>Vásárlás dátuma</th>
						<th>Törlés/Módosítás</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row=mysqli_fetch_array($eredmeny)):?>
					<tr>
						<td><?=$row['id']?></td>
						<td><?=$row['nev']?></td>
						<td><?=$row['honnan']?></td>
						<td><?=$row['hova']?></td>
						<td><?=$row['tipus']?></td>
						<td><?=$row['ar']?></td>
						<td><?=$row['vasardatum']?></td>
						<td style="font-size: 15px font-weight: bold;"><a href="deletejegy.php?id=<?=$row['id']?>"><img src="static/delete.jpg" style="height:15px; width: 15px;"></a>      /       <a href="jegyatad.php?id=<?=$row['id']?>"><img src="static/modify.jpg" style="height:15px; width: 15px;"></a> </td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>		
 </div>
<?php 
	$neveredmeny=mysqli_query($link, "SELECT id, nev FROM utas");
	$jarateredmeny=mysqli_query($link, "SELECT id, honnan, hova, maxkapacitas, tipus, ar FROM jarat");
/*2 opcio

1 opcio: embert kell hozza rendelni
- option- embernek a neve

1 opcio: jaratok
-optio - honnan hova tipus ar és csak akkor, ha van még hely*/
?>

<div class="container jaratform" style="border-radius: 5px; background-color: #f2f2f2; padding:20px 20px;">
	<h1 style="font-size: 20px;"> Jegy vásárlás </h1></br></br>
	<form method="post" action="jegyek.php">
		<label for="utas">Utas választása</label>
		<select id="utas" name="utas">
			<?php while($nevrow=mysqli_fetch_array($neveredmeny)): ?>
			<option value="<?php echo $nevrow['id']; ?>"><?php echo $nevrow['nev'];?></option>
			<?php endwhile; ?>
		</select>
		
		<label for="jarat">Járat választása</label>
		<select id="jarat" name="jarat">
			<?php while ($jaratrow=mysqli_fetch_array($jarateredmeny)):?>
			<?php 	$jaratcounteredmeny=mysqli_query($link,"SELECT COUNT(id) as szam from jegy WHERE jaratid='".$jaratrow['id']."';");
					$jaratcount=mysqli_fetch_array($jaratcounteredmeny);
		
			if($jaratcount['szam']<$jaratrow['maxkapacitas']){ ?>
			<option value="<?php echo $jaratrow['id']; ?>"><?php echo $jaratrow['honnan']." ".$jaratrow['hova']." ".$jaratrow['tipus']." ".$jaratrow['ar']."JMF"; ?></option>
			<?php } else{ } ?>
			
			<?php endwhile; ?>
		</select>
		<input type="submit" value="Létrehoz" name="uj">
	</form>
</div>
<?php
if(isset($_POST['uj'])){
	if(empty($_POST['utas']) or empty($_POST['jarat']))
	{
		echo "<br> Ne hagyjd üresen a mezőket! Bár őszintén szólva nem tudom ez hogyan sikerült.";
		return false;
	}
	
	$utasid=$_POST['utas'];
	$jaratid=$_POST['jarat'];
	$date = date('Y-m-d H:i:s a', time());
	
	
	$query=sprintf("INSERT INTO jegy(utasid,jaratid,vasardatum) VALUES('%d','%d','%s');",mysqli_real_escape_string($link, $utasid), mysqli_real_escape_string($link, $jaratid),mysqli_real_escape_string($link, $date));
	echo $query;
	
	mysqli_query($link, $query);
	mysqli_close($link);

}

?>
</body>
</html>