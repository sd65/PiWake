#!/bin/bash

cd /var/www/piwake3/


# VCS
for i in {21..26}
do
wget -O VCS/vcs-$i --post-data 'PHPSESSID=v0dicsge4p47ugnrsvbfa911r5' "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/gpu2vcs.php?semaine=$i&prof_etu=FIL&filiere=SRC_S2"
done

cd VCS

echo '0' > VCSALL

cat vcs* >> VCSALL

#echo 'Mise à jour VCS ok :' `date` >> ../log.txt


#// EDT
#for i in {21..26}
#do
#wget -O EDT/EDT-$i --post-data "PHPSESSID=v0dicsge4p47ugnrsvbfa911r5&semaine=$i" "http://syrah.iut.u-bordeaux3.fr/gpu/gpu/index.php?page_param=fpfilieres.php&cat=0&numpage=1&niv=2&clef=/305/306/"
#done

#echo 'Mise à jour EDT ok :' `date` >> log.txt
