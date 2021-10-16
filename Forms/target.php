<?php

if('POST' == $_SERVER['REQUEST_METHOD']){
    print "<p>Hello, ";
    //Print what was submitted in the form parameter caller "user"
    print $_POST['user'];
    print "!</p>";
}else{
    print "<p>Hello, Stranger!</p>";
}


?>