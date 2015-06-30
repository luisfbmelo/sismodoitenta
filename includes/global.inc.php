<?php
session_set_cookie_params(0);
//session_start();
//require('access.php');

include "connection.php";
//include "classes/testemunho.class.php";
include "functions.php";

//SE BROWSER FOR IE7 OU MENOR
function iever($compare=false, $to=NULL){
    if(!preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $m)
        || preg_match('#Opera#', $_SERVER['HTTP_USER_AGENT']))
        return false === $compare ? false : NULL;

    if(false !== $compare
        && in_array($compare, array('<', '>', '<=', '>=', '==', '!='))
        && in_array((int)$to, array(5,6,7,8,9,10))){
        return eval('return ('.$m[1].$compare.$to.');');
    }
    else{
        return (int)$m[1];
    }
}

if (iever('<=', 7)){
    include ('browser_require.php');
    exit();
}
?>