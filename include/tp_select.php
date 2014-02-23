<?php

if ($filiere == "SRC") {

if ($td == 1)
    $td_code = "SRC_S4A" ;

if ($td == 2)
    $td_code = "SRC_S4B" ;

if ($tp == 1)
    $tp_code = "SRC_S4A1" ;

if ($tp == 2)
    $tp_code = "SRC_S4A2" ;

if ($tp == 3)
    $tp_code = "SRC_S4B1" ;

} else if ($filiere == "MMI") {

if ($td == 1)
    $td_code = "MMI_S2A" ;

if ($td == 2)
    $td_code = "MMI_S2B" ;

if ($tp == 1)
    $tp_code = "MMI_S2A1" ;

if ($tp == 2)
    $tp_code = "MMI_S2A2" ;

if ($tp == 3)
    $tp_code = "MMI_S2B1" ;

} else {
    $tp_code = "" ;
    $td_code = "" ;
}

?>
