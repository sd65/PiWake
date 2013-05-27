#!/bin/bash

# This file is intented to be used in crontab

# Fetch VCS files
cd /var/www/piwake/

for i in {21..26}
do
	wget -O vcs/vcs-$i --post-data 'PHPSESSID=v0dicsge4p47ugnrsvbfa911r5' "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$i&prof_etu=FIL&filiere=SRC_S2"
done


# Update the files
clear > vcs/VCSALL
cat vcs/vcs* >> vcs/VCSALL


# Fill the database
script/updateDB.php


#Log
echo 'Mise à jour ok :' `date` >> log.txt



