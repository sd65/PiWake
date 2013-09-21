<?php

//Cookie !
if (!empty($_POST)) // Si on soumet le formulaire
{
	setcookie('enreg_semaine', $_POST['semaine'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_tp', $_POST['tp'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_td', $_POST['td'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_vue', $_POST['vue'], time() + 365*24*3600, null, null,false, true); 
	setcookie('enreg_annee', $_POST['annee'], time() + 365*24*3600, null, null,false, true); 
	
	$td = $_POST['td'] ;
	$tp = $_POST['tp'] ;
	$semaine = $_POST['semaine'] ;
	$vue = $_POST['vue'] ;
	$annee = $_POST['annee'] ;
}
else
{
	if (!empty($_COOKIE)) //Si on revient sur PiWake avec des Cookies remplis
	{
		$td = $_COOKIE['enreg_td'] ;
	       	$tp = $_COOKIE['enreg_tp'] ;
	        $semaine = $_COOKIE['enreg_semaine'] ;
        	$vue = $_COOKIE['enreg_vue'] ;
        	$annee = $_COOKIE['enreg_annee'] ;
	}
	else
	{
		$td = 1 ;
	        $tp = 1 ;
	        $vue = 1 ;
	        $annee = "SRC";
	        
	        if(date(N) == 5 && date(G) > 19) // Si vendredi et plus de 19h
	        	$semaine = date('W') + 1;
	        else
	        	$semaine = date('W') ;
        
	}

}

// Connexion BDD
include_once "config/piwake_conf.php" ;
$bdd = new PDO("mysql:host=localhost;dbname=PIWAKE;charset=utf8", $usernameDB, $passwordDB);

//Link
include_once "functions.php" ;


?>

<!DOCTYPE html>
<html lang="fr">

<head>	
	<title>PiWake 3.1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,200,100' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300' rel='stylesheet' type='text/css'>
	<script src="script/jquery.js" type="text/javascript"></script>
	<script src="script/script1.js" type="text/javascript"></script>
</head>


<body>

	<div id="wrapp">

	<div id="head">

		<h1>PiWake <span class="trucUseless">3<span id="petiteVersion">.1</span></span></h1>


		<h2><span class="trucUseless">S</span>imple <span class="trucUseless">R</span>apide <span class="trucUseless">C</span>onnecté</h2>


		<div id="formulaire"> 
			
			<form action="index.php" method="post">
			
			<select id="selectAnnee" name="annee" onchange="this.form.submit()">
				<option <?php if($annee=="SRC"){echo "selected" ;}?> value="SRC">SRC</option>
				<option <?php if($annee=="MMI"){echo "selected" ;}?> value="MMI">MMI</option>
			</select> 
				/			
			<select id="selectVue" name="vue" onchange="this.form.submit()">
				<option <?php if($vue==1){echo "selected" ;}?> value="1">Selon</option>
				<option <?php if($vue==0){echo "selected" ;}?> value="0">Tout</option>
			</select> 
				/
			<select id="selectTP" name="tp" onchange="this.form.submit()">
				<option <?php if($tp==1){echo "selected" ;}?> value="1">TP1</option>
				<option <?php if($tp==2){echo "selected" ;}?> value="2">TP2</option>
				<option <?php if($tp==3){echo "selected" ;}?> value="3">TP3</option>
			</select> 
				/
			<select id="selectTD" name="td" onchange="this.form.submit()" >
				<option <?php if($td==1){echo "selected" ;}?> value="1">TD1</option>
				<option <?php if($td==2){echo "selected" ;}?> value="2">TD2</option>
			</select>		
				/	
			<label for="semaine">Sem.</label>
			<select id="selectSemaine" name="semaine" onchange="this.form.submit()" >

			<?php
			$intervale_start= date(W) ;
			$intervale_end=52;
			for(;$intervale_start <= $intervale_end;$intervale_start++) {
			?>
				<option <?php if($semaine==$intervale_start){echo "selected" ;}?> value="<?php echo $intervale_start ?> "><?php echo $intervale_start ?></option>
			<?php } ?>
			</select>
			</form>
				
		</div>  <!-- Fin du formulaire -->


	
	</div>  <!-- Fin du Head -->

	<div id="tableau">

		<table>	
		
			<thead>
				<tr>
					<td class="jourTop">Jour</td>
					<?php	
						for ($heureDuJour=9;$heureDuJour<20;$heureDuJour++)
						{
							echo "<td  class=\"Heure\">" . $heureDuJour. "h</td>" ;
							echo "<td  class=\"demiHeure\"></td>" ;
						}
					?>
				</tr>
			</thead>
			
			</body>
		
		<?php
	
		if ($td == 1)
			$td = "SRC_S3A" ;
		
		if ($td == 2)
		    $td = "SRC_S3B" ;

	 	if ($tp == 1)
		    $tp = "SRC_S3A1" ;

	 	if ($tp == 2)
		    $tp = "SRC_S3A2" ;

	 	if ($tp == 3)
		    $tp = "SRC_S3B1" ;

	
	
		$requeteMois = $bdd->query("SELECT DISTINCT nomJour, jour, mois FROM EDT_SRC WHERE 
		type='" .$tp . "' AND semaine=" . $semaine . 
		" OR type='" .$td . "' AND semaine=" . $semaine .
		" OR type='SRC_S3' AND semaine=" . $semaine .  " ORDER BY jour") ;
	
		$nomMois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"); 
	
		while ($lines = $requeteMois->fetch()) {
	
			echo '<tr>' ;
			
				if ($vue==1)
					drawTimeTableSelective($lines['nomJour'], $lines['jour'], $nomMois[--$lines['mois']], $tp, $td, $semaine,$bdd) ; 
				else
					drawTimeTableGlobal($lines['nomJour'], $lines['jour'], $nomMois[--$lines['mois']], $semaine,$bdd) ; 
					
			echo "</tr>" ;
	
		}
		?>
			</tbody>
	
	
		</table>
	
	
		<div id="footer">	
			<a href="https://github.com/sd65/PiWake" title="Le site du projet">All rights reserved &#183; <img src="picture/cat.png" alt="Calendar Mew"/> &#183; Explore on GitHub</a>
		</div>

	</div> <!-- Fin du Tableau -->
	
</div> <!-- Fin du Wrapp -->

</body>

</html>
