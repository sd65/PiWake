#!/bin/bash

# This file is intented to be used in crontab

cd `dirname $0`

# Getting Cookie on Sattelys Server
wget -O /dev/null --keep-session-cookies --save-cookies "cookie/cookie" --post-data "modeconnect=connect&util=sdoignon&acct_pass=123" 'http://syrah.iut.u-bordeaux3.fr/gpu/sat/index.php?page_param=accueilsatellys.php&cat=0&numpage=1&niv=0&clef=/'

# Using it for getting Calendars
for filiere in "SRC" "MMI" "PUB_1" "PUB_2"
do
	case $filiere in
		SRC) code_filiere="SRC_S3" ;;
		MMI) code_filiere="MMI_S1" ;;
		PUB_1) code_filiere="PUB_S1" ;;
		PUB_2) code_filiere="PUB_S3" ;;
	esac

	for (( week=$(date +"%V") ; week<=52 ; week++))
	do
		echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Updating $filiere on week $week @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@"
		wget -O vcs/$filiere/vcs-$week --load-cookies "cookie/cookie" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$week&prof_etu=FIL&filiere=$code_filiere"
	done

	# Update the files
	clear > vcs/$filiere/VCSALL
	cat vcs/$filiere/vcs-* >> vcs/$filiere/VCSALL

done


# Fill the database
script/updateDB.php

#Log
echo 'Mise à jour :' `date` >> log/log.txt
