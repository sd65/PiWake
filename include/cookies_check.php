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

?>
