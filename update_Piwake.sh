#!/bin/bash

# This file is intented to be used in crontab

# Fetch VCS files
cd /usr/share/nginx/www/piwake/

# Login to Sattelys Server

wget -O /dev/null --keep-session-cookies --save-cookies "cookie/cookie" --post-data "modeconnect=connect&util=sdoignon&acct_pass=123" 'http://syrah.iut.u-bordeaux3.fr/gpu/sat/index.php?page_param=accueilsatellys.php&cat=0&numpage=1&niv=0&clef=/'

for i in {38..52}
do
	wget -O vcs/vcs-$i --load-cookies cookie/cookie "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$i&prof_etu=FIL&filiere=SRC_S3"
done


# Update the files
clear > vcs/VCSALL
cat vcs/vcs* >> vcs/VCSALL


# Fill the database
script/updateDB.php


#Log
echo 'Mise à jour ok :' `date` >> log.txt



