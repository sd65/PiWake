#!/bin/bash

# This file is intented to be used in crontab

# Fetch VCS files
cd /usr/share/nginx/www/piwake/

for i in {38..52}
do
	wget -O vcs/vcs-$i --post-data 'PHPSESSID=fs0c523d41aiqg3t1bj9a1va22' "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$i&prof_etu=FIL&filiere=SRC_S3"
done


# Update the files
clear > vcs/VCSALL
cat vcs/vcs* >> vcs/VCSALL


# Fill the database
script/updateDB.php


#Log
echo 'Mise à jour ok :' `date` >> log.txt



