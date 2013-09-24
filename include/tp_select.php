<?php

if ($filiere == "SRC") {

if ($td == 1)
    $td_code = "SRC_S3A" ;

if ($td == 2)
    $td_code = "SRC_S3B" ;

if ($tp == 1)
    $tp_code = "SRC_S3A1" ;

if ($tp == 2)
    $tp_code = "SRC_S3A2" ;

if ($tp == 3)
    $tp_code = "SRC_S3B1" ;

} else if ($filiere == "MMI") {

if ($td == 1)
    $td_code = "MMI_S1A" ;

if ($td == 2)
    $td_code = "MMI_S1B" ;

if ($tp == 1)
    $tp_code = "MMI_S1A1" ;

if ($tp == 2)
    $tp_code = "MMI_S1A2" ;

if ($tp == 3)
    $tp_code = "MMI_S1B1" ;

} else {
    $tp_code = "" ;
    $td_code = "" ;
}

?>
