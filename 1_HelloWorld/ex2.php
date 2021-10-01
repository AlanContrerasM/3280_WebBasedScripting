<?php
    $test = 100.00 - 100;
    // $test = "zero";
    // $test = "0.0"; //true
    // $test = "false";
    // $test = 0 + "true";
    // $test = 0.000;
    // $test = strcmp("false", "False");
    $test2 = 0 <=> "0"; //returns 0 if equal, returns greater than 0 if first is bigger, andless than 0 if second is bigger

    if($test){
        print "It is true\n<br>";
    }else{
        print "It is false\n <br>";
    }

    if($test2 == 0){
        print "Equal";
    }elseif($test >0){
        print "0 is greater than '0'";
    }else{
        print "0 is less than '0'";
    }

    print "</br>Let's do some exercises</br>";

    $x = 5 % 3 - 6 % 4;
    print($x . "</br>");

    if(![]){
        print("true");
    }else{
        print("false");
    }

    print <<<HB
        <html>

        <head></head>

        <body></br>Hello World!</br></body>

        </html>

    HB;

    print 'Test'; # Today;


    print "<br/> <br/><br/><br/><h2>New Tests</h2><br/><br/>";

    // $test3 = 0 + "true";
    // $test3 = 0.000;
    // $test3 = strcmp("false", "False");
    $test3 = 0 <=> "0"; //returns 0 if equal, returns greater than 0 if first is bigger, andless than 0 if second is bigger

    $ok = "cold";

    if(12 % 5 - 20 / 2){
        print "It is true\n<br>";
    }else{
        print "It is false\n <br>";
    }

    $s = "cool";

    print strlen($s);

    print "<html><head></head><body>";

    print <<<BLK

    <i>Hi!</i>

    BLK;

    print "</body></html>";

    print $x * 5 % 3 * 6;

    $xoy=1;

    $yoy=2;

    print "$xoy$yoy"; 


   


?>