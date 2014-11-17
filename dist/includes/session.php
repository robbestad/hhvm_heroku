<?php
$block=['bingbot','Googlebot','Read ahead agent','MJ12bot','discobot','msnbot','archive.org_bot','Baiduspider'];
$start_session=true;
if(!empty($_SERVER['HTTP_USER_AGENT'])){
    foreach($block as $bot){
        if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)){
            $start_session = false;
        }
    }
}
if($start_session){
    $session_started='';
    if(!empty($_POST["SID"])){
        ## HVIS SID ER ANGITT VIA POST, HENT INNHOLDET MEN GENERER NY SID-ID & SLETT DEN GAMLE
        setcookie("sess", $_POST["SID"]);
        $session_started=session_id($_POST["SID"]);
    }
    else if(!empty($_COOKIE["sess"])) $session_started=session_id($_COOKIE["sess"]);

    if (empty($session_started))
        session_start();
}
