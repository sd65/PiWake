<?php

//Cookie !
setcookie('enreg_semaine', $_POST['semaine'], time() + 365*24*3600, null, null,false, true); 

// Connexion
$bdd = new PDO("sqlite:../PIWAKE");

//Link
include_once "functions.php" ;

// Post Data
$td = $_POST['td'] ;
$tp = $_POST['tp'] ;
$semaine = $_POST['semaine'] ;


?>

<!DOCTYPE html>
<html lang="fr">

<head>

	<meta charset="utf-8">
	
	<title>PiWake3</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,200,100' rel='stylesheet' type='text/css'>
	
</head>


<body>

<div id="wrapp">

<div id="head">

 <h1> PiWake<span class="trucUseless">3</span></h1>


<h2><span class="trucUseless">S</span>imple <span class="trucUseless">R</span>apide <span class="trucUseless">C</span>onnecté</h2>


	<div id="formulaire">
			
		<form action="index.php" method="post">
		
		<label for="tp">TP :</label>
		<select name="tp" onchange="this.form.submit()">
			<option <?php if($tp==1){echo "selected" ;}?> value="1">TP1</option>
			<option <?php if($tp==2){echo "selected" ;}?> value="2">TP2</option>
			<option <?php if($tp==3){echo "selected" ;}?> value="3">TP3</option>
		</select> 
	
		<label for="td">TD :</label>
		<select name="td" onchange="this.form.submit()" >
			<option <?php if($td==1){echo "selected" ;}?> value="1">TD1</option>
			<option <?php if($td==2){echo "selected" ;}?> value="2">TD2</option>
		</select>		
			
		
		<label for="semaine">Semaine :</label>
		<select name="semaine" onchange="this.form.submit()" >
			<option <?php if($semaine==22){echo "selected" ;}?> value="22">22</option>
			<option <?php if($semaine==23){echo "selected" ;}?> value="23">23</option>
			<option <?php if($semaine==24){echo "selected" ;}?> value="24">24</option>
			<option <?php if($semaine==25){echo "selected" ;}?> value="25">25</option>
			<option <?php if($semaine==26){echo "selected" ;}?> value="26">26</option>
		</select>
		</form>
				
	</div> 

	
</div>

<div id="tableau">

	<table>
		
		<thead>
			<tr>
				<td class="jourTop" >Jour</td>
				<?php	
					for ($heureDuJour=9;$heureDuJour<20;$heureDuJour++)
					{
						echo "<td  class=\"Heure\">" . $heureDuJour. "h</td>" ;
						echo "<td  class=\"demiHeure\">30</td>" ;
					}
				?>
			</tr>
			
			
		</thead>
	
		</body>
		
	<?php
	
	if ($td == 1)
		$td = "SRC_S2A" ;
		
	if ($td == 2)
        $td = "SRC_S2B" ;

 	if ($tp == 1)
        $tp = "SRC_S2A1" ;

 	if ($tp == 2)
        $tp = "SRC_S2A2" ;

 	if ($tp == 3)
        $tp = "SRC_S2B1" ;

	
	
	$requeteMois = $bdd->query("SELECT DISTINCT nomJour, jour, mois FROM EDT WHERE 
	type='" .$tp . "' AND semaine=" . $semaine . 
	" OR type='" .$td . "' AND semaine=" . $semaine .
	" OR type='SRC_S2' AND semaine=" . $semaine .  " ORDER BY jour") ;
	
	$nomMois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"); 
	
	while ($lines = $requeteMois->fetch()) {
	
		echo '<tr>' ;
			
			drawTimeTable($lines['nomJour'], $lines['jour'], $nomMois[--$lines['mois']], $tp, $td, $semaine,$bdd) ; 
		
		echo "</tr>" ;
	
	}
	?>
		</tbody>
	
	
	</table>
	
	
	


<table id="Legende">
	<caption>Légende</caption>
	<tr>
		<td class="LegendeClasseEntiere">Classe Entière</td>
		<td class="LegendeTP">TP</td>
		<td class="LegendeTD">TD</td>
	</tr> 
</table>

</div>
</div>

</body>
</html>
