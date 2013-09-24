#!/usr/bin/php

<?php

// Erreurs on
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Connexion BDD
include_once "config/piwake_conf.php" ;
$bdd = new PDO("mysql:host=localhost;dbname=PIWAKE;charset=utf8", $usernameDB, $passwordDB);

$tabFiliere = array( "SRC", "MMI", "PUB_1", "PUB_2") ;


foreach ($tabFiliere as $filiere) {	

// On flush tout pour éviter les doublons			
	$bdd->exec("DELETE FROM EDT_". $filiere ." WHERE 1") ; 


	$lines = file($piwakePath . "vcs/" . $filiere .'/VCSALL');

	foreach ($lines as $lineNumber => $lineContent) // Pour chaque ligne
	{

		
		if(stripos($lineContent, "BEGIN:VEVENT") !== false)
		{

			$description = $lines[$lineNumber+4] ;
			$dStart = $lines[$lineNumber+7] ;
			$dEnd = $lines[$lineNumber+8] ;
			
			// Sépare par : puis sépare par espace
			$description = preg_split("#[:]#", $description) ; 
			
			//Salle
			$salle = preg_split("#[\s]#",$description[2]) ;
			$salle = $salle[0] ;
			
			
			//Salle
			$prof = preg_split("#[\s]#",$description[3]) ;
			$prof = $prof[0] ;
			
			//Coupe au slash
			$description = preg_split("#\\\#",$description[4]) ;
			
			$matiere = preg_replace("#=C3=A9#", "é",$description[0]) ; // & corrige les e
			$matiere = preg_replace("#=C3=A8#", "é",$matiere) ; // & corrige les e
			$matiere = preg_replace("#=C3=89#", "E",$matiere) ; // & corrige les e
			$matiere = preg_replace("#de l'informatio#", "de l'information",$matiere) ; // & corrige les e

			$type = $description[1] ;
			
			$semestre = substr ($description[2], 4) ;

			$annee = substr ($dStart, 8, 4) ;
			$mois = substr ($dStart, 12, 2) ;
			$jour = substr ($dStart, 14, 2) ;
			
			//Calcul de la semaine
			$semaine = $jour . "-" . $mois . "-" . $annee ;
			$semaine = strtotime($semaine) ;
			$semaine = (int)date('W', $semaine); 
			
			//Nom jour
			$nomJour =  strtotime($jour . "-". $mois . "-". $annee) ; 
			$nomJour = date('w', $nomJour) ;
			$jours = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi') ;
			$nomJour = $jours[$nomJour-1] ;
			
			$startHeure = 2 + substr ($dStart, 17, 2) ; //GMT +2
			if ($startHeure < 10) { $startHeure = "0" . $startHeure ;} //Fix first zero
			$startMinute = substr ($dStart, 19, 2) ;
			$startSeconde = substr ($dStart, 21, 2) ;
			
			$endHeure = 2 + substr ($dEnd, 15, 2) ;
			if ($endHeure < 10) { $endHeure = "0" . $endHeure ;} 
			$endMinute = substr ($dEnd, 17, 2) ;
			$endSeconde = substr ($dEnd, 19, 2) ;
			
			
			$startHeure = $startHeure ; //. $startMinute . $startSeconde ;
			$endHeure = $endHeure ;//. $endMinute . $endSeconde ;
			
			
			echo "Debug : " . $semestre ." # " . $semaine ." # " .$nomJour." # " .$annee." # " .$mois." # " .$jour." # " . $matiere." # " . $prof." # " . $salle. $type. " # " .$startHeure. " # " .$endHeure . " # " . $filiere . "<br/>";
			
			

			$req  = $bdd->prepare("INSERT INTO EDT_". $filiere ." (semestre, semaine, nomJour, annee, mois, jour, matiere, prof, salle, type, startHeure, endHeure) VALUES (:semestre, :semaine, :nomJour, :annee, :mois, :jour, :matiere, :prof, :salle, :type, :startHeure, :endHeure)");
			
			$req->execute(
				array(
					'semestre' => $semestre,
					'semaine' => $semaine,
					'nomJour' => $nomJour,
					'annee' => $annee,
					'mois' => $mois,
					'jour' => $jour,
					'matiere' => $matiere,
					'prof' => $prof,
					'salle' => $salle,
					'type' => $type,
					'startHeure' => $startHeure,
					'endHeure' => $endHeure
					)
				);
			

			// Pour jump prochain begin
			$lineNumber += 11 ;
		}
		
		
	}
}
?>
