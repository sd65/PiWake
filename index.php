<?php

//Cookie !
if (!empty($_POST)) // Si on soumet le formulaire
{
	setcookie('enreg_semaine', $_POST['semaine'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_tp', $_POST['tp'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_td', $_POST['td'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_vue', $_POST['vue'], time() + 365*24*3600, null, null,false, true); 
	
	$td = $_POST['td'] ;
	$tp = $_POST['tp'] ;
	$semaine = $_POST['semaine'] ;
	$vue = $_POST['vue'] ;
}
else
{
	if (!empty($_COOKIE)) //Si on revient sur PiWake avec des Cookies remplis
	{
	$td = $_COOKIE['enreg_td'] ;
        $tp = $_COOKIE['enreg_tp'] ;
        $semaine = $_COOKIE['enreg_semaine'] ;
        $vue = $_COOKIE['enreg_vue'] ;
	}
	else
	{
	$td = 1 ;
        $tp = 1 ;
        $semaine = date('W') ;
        $vue = 1 ;
	}

}



// Connexion
$bdd = new PDO("sqlite:../PIWAKE");

//Link
include_once "functions.php" ;


?>

<!DOCTYPE html>
<html lang="fr">

<head>	
	<title>PiWake3</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,200,100' rel='stylesheet' type='text/css'>
</head>


<body>

	<div id="wrapp">

	<div id="head">

		<h1>PiWake<span class="trucUseless">3</span></h1>


		<h2><span class="trucUseless">S</span>imple <span class="trucUseless">R</span>apide <span class="trucUseless">C</span>onnecté</h2>


		<div id="formulaire"> 
			
			<form action="index.php" method="post">
			
			<label for="vue">Vue :</label>
			<select id="vue" name="vue" onchange="this.form.submit()">
				<option <?php if($vue==0){echo "selected" ;}?> value="0">Sélective</option>
				<option <?php if($vue==1){echo "selected" ;}?> value="1">Générale</option>
				<option value="1">TEST</option>
				<option  value="1">EN COURS</option>
			</select>
		
			<label for="tp">TP :</label>
			<select id="selectTP" name="tp" onchange="this.form.submit()">
				<option <?php if($tp==1){echo "selected" ;}?> value="1">TP1</option>
				<option <?php if($tp==2){echo "selected" ;}?> value="2">TP2</option>
				<option <?php if($tp==3){echo "selected" ;}?> value="3">TP3</option>
			</select> 
	
			<label for="td">TD :</label>
			<select id="selectTD" name="td" onchange="this.form.submit()" >
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
				
		</div>  <!-- Fin du formulaire -->


	
	</div>  <!-- Fin du Head -->

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
			
				drawTimeTable($vue, $lines['nomJour'], $lines['jour'], $nomMois[--$lines['mois']], $tp, $td, $semaine,$bdd) ; 
		
			echo "</tr>" ;
	
		}
		?>
			</tbody>
	
	
		</table>
	
	
		<div id="footer">	
			<a href="../piwake2" title="PiWake2">Revert to old Piwake</a> | 
			<a href="https://github.com/sd65/PiWake" title="Le site du projet">Explore on GitHub</a>
		</div>

	</div> <!-- Fin du Tableau -->
	
</div> <!-- Fin du Wrapp -->

</body>

</html>
