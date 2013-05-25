#!/bin/bash

# This file is intented to be used in crontab

cd /var/www/piwake3/


for i in {21..26}
do
wget -O vcs/vcs-$i --post-data 'PHPSESSID=v0dicsge4p47ugnrsvbfa911r5' "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$i&prof_etu=FIL&filiere=SRC_S2"
done

clear > vcs/VCSALL

cat vcs/vcs* >> vcs/VCSALL

echo 'Mise à jour VCS ok :' `date` >> log.txt


script/updateDB.php

echo 'Mise à jour DB ok :' `date` >> log.txt