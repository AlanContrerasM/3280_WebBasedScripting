<?php
    //sessions is first
    //sessionsssss
    session_start();

    //lets start with cookies
    //setcookie has to be top before any other code
    // setcookie('userid', 'ralph');//can bne string or number, other stuff gets converted o ASCII, space is %20 for example.
    //for time basically uses unix epoich, seconds sinc jan 1 1970, + whatever time we want to give it.
    // setcookie('userid', 'ralph', time() + 60*60); //default, 24 min, here we set 1 hour. 60*60*24, is 1 day.
    //expires at noon
    $d = new DateTime("2022-10-01 12:00:00");
    setcookie('userid', 'ralph', $d->format('U'));

    //coookies will only be available to parent directoryes, if it was set on .../catalog/buy.php, it will only be available for pages with /catalog/
    //if you want it to be available to every page
    setcookie('short-userid', 'ralph', 0, '/');//is is for default time, 24 mins.

    //you can restrict cookies to domains
    setcookie('short-userid', 'ralph', 0, '/', '.example.com');//accepts mail.example.com, etc. if we had restricted to www.example.com everything else is restricted

    //security related parameters
    // 6th and 7th parameters, is that client can only return cookies over secure https, 7th, is so the cookie is httpOnly
    setcookie('short-userid', 'ralph', 0, null, null, true, true);

    //to delete cookie
    setcookie('short-userid', ''); //just call it empty



    

?>
<?php

    
    //Alan Contreras 
    //300330244
    require 'lib.php';

    
    //calling from lib.php
    display_html_head("cookies");

    
    print 'Hello, ' . $_COOKIE['userid'];
    print '<br/>';
    if(isset($_SESSION['count'])){
        $_SESSION['count'] = $_SESSION['count'] + 1;
    }else{
        $_SESSION['count'] = 1;
    }

    print "You've looked at this page $_SESSION[count] times ";

    // to delete a session
    unset($_SESSION['count']);
    

    display_html_foot();
    



?>