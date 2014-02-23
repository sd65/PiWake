#!/bin/bash

# This file is intented to be used in crontab

cd `dirname $0`

# Getting Cookie on Sattelys Server
wget -q -O /dev/null --keep-session-cookies --save-cookies "cookie/cookie" --post-data "modeconnect=connect&util=sdoignon&acct_pass=123" 'http://syrah.iut.u-bordeaux3.fr/gpu/sat/index.php?page_param=accueilsatellys.php&cat=0&numpage=1&niv=0&clef=/'
wget -q -O /dev/null --keep-session-cookies --save-cookies "cookie/cookie" --post-data "modeconnect=connect&util=sdoignon&acct_pass=123" 'http://syrah.iut.u-bordeaux3.fr/gpu/sat/index.php?page_param=accueilsatellys.php&cat=0&numpage=1&niv=0&clef=/'

#Clearing old data
rm -f vcs/SRC/*
rm -f vcs/MMI/*

# Using it for getting Calendars
for filiere in "MMI" "SRC"
do
        case $filiere in
                SRC) code_filiere="SRC_S4" ;;
                MMI) code_filiere="MMI_S2" ;;
        esac

        for (( week=$((10#`date +"%V"`)) ; week<=26 ; week++))
        do
                echo "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Updating $filiere on week $week @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@"
		wget -q -O vcs/$filiere/vcs-$week --load-cookies "cookie/cookie" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$week&prof_etu=FIL&filiere=$code_filiere"
	done
        # Update the files
        clear > vcs/$filiere/VCSALL
        cat vcs/$filiere/vcs-* >> vcs/$filiere/VCSALL

done


# Fill the database
script/updateDB.php

echo 'MAJ :' `date` >> log/log.txt
echo 'FINISHED!'
