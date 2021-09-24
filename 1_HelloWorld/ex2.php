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
?>