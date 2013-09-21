<?php

function drawTimeTableSelective ($nomJour, $jour, $mois, $tp, $td, $semaine, $bdd, $annee) 
{
	if ($annee == "SRC") { 

		$requeteCours = "SELECT * FROM EDT_SRC 
		LEFT JOIN NOMSPROFS ON EDT_SRC.prof = NOMSPROFS.name
		WHERE type='" .$tp ."' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
		" OR type='" .$td ."' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
		" OR type='SRC_S3' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
		" ORDER BY startHeure" ;
		

		$requeteCours = $bdd->query($requeteCours) ;
		
		
		// Titre
		echo "<td class=\"tjour\" ><p class=\"pjour\"><span class=\"jourJour\"> " . substr($nomJour,0,3) . ".</span> 
		<span class=\"jourNum\">" . $jour . "</span><br/>
		<span class=\"jourMois\">" . $mois . "</span></p></td>" ;

		$lastCours = 9 ;
		
		// Infos
		while ($lines = $requeteCours->fetch()) 
		{

			$duree = $lines['endHeure'] - $lines['startHeure'] ;
			$duree *= 2 ; //Les demi-heures

			if ($lastCours < $lines['startHeure']) //Si un trou d'emploi du temps, on rajoute du vide
			{
				$difference =   $lines['startHeure'] - $lastCours   ;
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
		
		if ($lastCours<20)
		{
			$delta = 20 - $lastCours ;
			$delta *=2 ;
			echo "<td class=\"vide\" colspan=" . $delta  . "></td>" ;
		}

	} else { // Si MMI

		$requeteCours = "SELECT * FROM EDT_MMI
		LEFT JOIN NOMSPROFS ON EDT_MMI.prof = NOMSPROFS.name
		WHERE type='" .$tp ."' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
		" OR type='" .$td ."' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
		" OR type='MMI_S1' AND nomJour='" . $nomJour . "' AND semaine=" . $semaine .
		" ORDER BY startHeure" ;
		

		$requeteCours = $bdd->query($requeteCours) ;
		
		
		// Titre
		echo "<td class=\"tjour\" ><p class=\"pjour\"><span class=\"jourJour\"> " . substr($nomJour,0,3) . ".</span> 
		<span class=\"jourNum\">" . $jour . "</span><br/>
		<span class=\"jourMois\">" . $mois . "</span></p></td>" ;

		$lastCours = 9 ;
		
		// Infos
		while ($lines = $requeteCours->fetch()) 
		{

			$duree = $lines['endHeure'] - $lines['startHeure'] ;
			$duree *= 2 ; //Les demi-heures

			if ($lastCours < $lines['startHeure']) //Si un trou d'emploi du temps, on rajoute du vide
			{
				$difference =   $lines['startHeure'] - $lastCours   ;
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
		
		if ($lastCours<20)
		{
			$delta = 20 - $lastCours ;
			$delta *=2 ;
			echo "<td class=\"vide\" colspan=" . $delta  . "></td>" ;
		}

	} // Fin Si MMI

} // Fin de la fonction ///////////////////////////////////////////










function drawTimeTableGlobal($nomJour, $jour, $mois, $semaine, $bdd, $annee) 
{
	if ($annee == "SRC") { 

		$requeteCours = "SELECT * FROM EDT_SRC 

		WHERE semaine=" . $semaine ." AND jour='". $jour ."'
		ORDER BY startHeure, type" ;

		$requeteCours = $bdd->query($requeteCours) ;


	// Titre
		echo "<td class=\"tjour\" ><p class=\"pjour\"><span class=\"jourJour\"> " . substr($nomJour,0,3) . ".</span> 
		<span class=\"jourNum\">" . $jour . "</span><br/>
		<span class=\"jourMois\">" . $mois . "</span></p></td>" ;

		$lastCours = 9 ;


	// Infos
		while ($lines = $requeteCours->fetch()) 
		{

		//Calcul des couleurs
			if (strlen($lines['type']) == 6)
				$couleur = "couleurClasseEntiere" ;

			if (strlen($lines['type']) == 7)
				$couleur = "couleurTD" ;

			if (strlen($lines['type']) == 8)
				$couleur = "couleurTP" ;


		// Verbose des TP TD

			$type = $lines['type']  ;

			if ($type == "SRC_S3")
				{ $type = "" ; $timbre="timbre_ClasseEntiere"; }

			if ($type == "SRC_S3A")
				{ $type = "TD1" ; $timbre="timbre_td"; }

			if ($type == "SRC_S3B")
				{ $type = "TD2" ; $timbre="timbre_td"; }

			if ($type == "SRC_S3A1")
				{ $type = "TP1" ; $timbre="timbre_td"; }

			if ($type == "SRC_S3A2")
				{ $type = "TP2" ; $timbre="timbre_tp"; }

			if ($type == "SRC_S3B1")
				{ $type = "TP3" ; $timbre="timbre_tp"; }




			// Calcul de la durée du cours
			$duree = $lines['endHeure'] - $lines['startHeure'] ; 
			$duree *= 2 ; //Les demi-heures		
			
			
			//Si un trou d'emploi du temps, on rajoute du vide
			if ($lastCours < $lines['startHeure']) 
			{
				$difference =  $lines['startHeure'] - $lastCours   ;
				$lastCours += $difference ;	
				$difference *= 2 ;
				echo "<td  class=\"vide\" colspan=" . $difference ."></td>" ;					
			}
			
			// Si nouvelle heure
			if ($lastCours !== $lines['endHeure']) 
			{
				echo "</td><td class=\"$couleur case\"  colspan=" . $duree  .">" ;
				// Heure de fin du cours
				$lastCours = $lines['endHeure'] ;
			}
			
			// Cellule
			echo "<div class=\"cellule $timbre\">
			<p class=\"jourMatiere\">" . $lines['matiere'] . "</p>
			<p class=\"jourProf\">" . $lines['prof'] ."</p>
			<p class=\"jourType\">" . $type ."</p>
			<p class=\"jourSalle\">". $lines['salle'] . "</p></div>";	
			
		} // Fin du While
	
	
		if ($lastCours<20)
		{
			$delta = 20 - $lastCours ;
			$delta *=2 ;
			echo "<td class=\"vide\" colspan=" . $delta  . "></td>" ;
		}

	} else { // Si MMI

		$requeteCours = "SELECT * FROM EDT_MMI 

		WHERE semaine=" . $semaine ." AND jour='". $jour ."'
		ORDER BY startHeure, type" ;

		$requeteCours = $bdd->query($requeteCours) ;


	// Titre
		echo "<td class=\"tjour\" ><p class=\"pjour\"><span class=\"jourJour\"> " . substr($nomJour,0,3) . ".</span> 
		<span class=\"jourNum\">" . $jour . "</span><br/>
		<span class=\"jourMois\">" . $mois . "</span></p></td>" ;

		$lastCours = 9 ;


	// Infos
		while ($lines = $requeteCours->fetch()) 
		{

		//Calcul des couleurs
			if (strlen($lines['type']) == 6)
				$couleur = "couleurClasseEntiere" ;

			if (strlen($lines['type']) == 7)
				$couleur = "couleurTD" ;

			if (strlen($lines['type']) == 8)
				$couleur = "couleurTP" ;


		// Verbose des TP TD

			$type = $lines['type']  ;

			if ($type == "MMI_S1")
				{ $type = "" ; $timbre="timbre_ClasseEntiere"; }

			if ($type == "MMI_S1A")
				{ $type = "TD1" ; $timbre="timbre_td"; }

			if ($type == "MMI_S1B")
				{ $type = "TD2" ; $timbre="timbre_td"; }

			if ($type == "MMI_S1A1")
				{ $type = "TP1" ; $timbre="timbre_td"; }

			if ($type == "MMI_S1A2")
				{ $type = "TP2" ; $timbre="timbre_tp"; }

			if ($type == "MMI_S1B1")
				{ $type = "TP3" ; $timbre="timbre_tp"; }




			// Calcul de la durée du cours
			$duree = $lines['endHeure'] - $lines['startHeure'] ; 
			$duree *= 2 ; //Les demi-heures		
			
			
			//Si un trou d'emploi du temps, on rajoute du vide
			if ($lastCours < $lines['startHeure']) 
			{
				$difference =  $lines['startHeure'] - $lastCours   ;
				$lastCours += $difference ;	
				$difference *= 2 ;
				echo "<td  class=\"vide\" colspan=" . $difference ."></td>" ;					
			}
			
			// Si nouvelle heure
			if ($lastCours !== $lines['endHeure']) 
			{
				echo "</td><td class=\"$couleur case\"  colspan=" . $duree  .">" ;
				// Heure de fin du cours
				$lastCours = $lines['endHeure'] ;
			}
			
			// Cellule
			echo "<div class=\"cellule $timbre\">
			<p class=\"jourMatiere\">" . $lines['matiere'] . "</p>
			<p class=\"jourProf\">" . $lines['prof'] ."</p>
			<p class=\"jourType\">" . $type ."</p>
			<p class=\"jourSalle\">". $lines['salle'] . "</p></div>";	
			
		} // Fin du While
	
	
		if ($lastCours<20)
		{
			$delta = 20 - $lastCours ;
			$delta *=2 ;
			echo "<td class=\"vide\" colspan=" . $delta  . "></td>" ;
		}

	} // Sin si MMI

} // Fin de la fonction


?>
