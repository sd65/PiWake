#!/bin/bash

# This file is intented to be used in crontab

# Fetch folder
cd /usr/share/nginx/www/piwake/

# Getting Cookie on Sattelys Server
wget -O /dev/null --keep-session-cookies --save-cookies "cookie/cookie" --post-data "modeconnect=connect&util=sdoignon&acct_pass=123" 'http://syrah.iut.u-bordeaux3.fr/gpu/sat/index.php?page_param=accueilsatellys.php&cat=0&numpage=1&niv=0&clef=/'

# Using it for SRC Callendars
for (( week=$(date +"%V") ; week<=52 ; week++))
do
wget -O vcs/SRC/vcs-$week --load-cookies "cookie/cookie" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$week&prof_etu=FIL&filiere=SRC_S3"
done

# Using it for MMI Callendars
for (( week=$(date +"%V") ; week<=52 ; week++))
do
wget -O vcs/MMI/vcs-$week --load-cookies "cookie/cookie" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$week&prof_etu=FIL&filiere=MMI_S1"
done

# Update the files
clear > vcs/SRC/VCSALL
clear > vcs/MMI/VCSALL
cat vcs/SRC/vcs-* >> vcs/SRC/VCSALL
cat vcs/MMI/vcs-* >> vcs/MMI/VCSALL

# Fill the database
script/updateDB.php

#Log
echo 'Mise à jour :' `date` >> log/log.txt
