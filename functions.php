<?php

function drawTimeTable ($nomJour, $jour, $mois, $tp, $td, $semaine, $bdd) 
{
	
	$requeteCours = "SELECT * FROM EDT 
	LEFT JOIN NOMSPROFS ON EDT.prof = NOMSPROFS.name
	WHERE type='" .$tp ."' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
	" OR type='" .$td ."' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
	" OR type='SRC_S2' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
	" ORDER BY startHeure" ;
	

	$requeteCours = $bdd->query($requeteCours) ;
	
	
	// Titre
	echo "<td class=\"tjour\" ><p class=\"pjour\"><span class=\"jourJour\"> " . substr($nomJour,0,3) . ".</span> 
	<span class=\"jourNum\">" . $jour . "</span><br/>
	<span class=\"jourMois\">" . $mois . "</span></p></td>" ;

	$lastCours = 9 ;
	$sommeCours = 0 ;
	$dureeTotale = 0 ;
	
	// Infos
	while ($lines = $requeteCours->fetch()) 
	{
	
		$duree = $lines['endHeure'] - $lines['startHeure'] ;
		$sommeCours += $duree ; 
		$duree *= 2 ; //Les demi-heures
	
		if ($lastCours < $lines['startHeure']) //Si un trou d'emploi du temps, on rajoute du vide
		{
			$difference =   $lines['startHeure'] - $lastCours   ;
			$sommeCours += $difference ;
			$difference *= 2 ;
			echo "<td  class=\"vide\" colspan=" . $difference ."></td>" ;
			$lastCours += $difference ;						
		}
				
		$lastCours = $lines['endHeure'] ;
		
		//Calcul des couleurs
		if (strlen($lines['type']) == 6)
			$couleur = "couleurClasseEntiere" ;
			
		if (strlen($lines['type']) == 7)
			$couleur = "couleurTD" ;
				
		if (strlen($lines['type']) == 8)
			$couleur = "couleurTP" ;
		
		echo "<td class=\"$couleur\"  colspan=" . $duree  .">
		<div class=\"cellule\">
		<p class=\"jourMatiere\">" . $lines['matiere'] . "</p>
		<p class=\"jourProf\">" . $lines['realName'] ."</p>
		<p class=\"jourSalle\">". $lines['salle'] . "</div></p></td>";
		
	} // Fin du While
	
	
	if ($sommeCours<10)
	{
		$delta = 11 - $sommeCours ;
		$delta *=2 ;
		echo "<td class=\"vide\" colspan=" . $delta  . "></td>" ;
	}

} // Fin de la fonction
	
?>
