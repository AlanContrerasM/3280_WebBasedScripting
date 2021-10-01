<?php

function page_header($color = '#cc3399'){
    print "<html><head><title>My site</title></head>";
    print '<body bgColor="' . $color . '">';

    #return $color;
}

page_header();

function restaurant_check($meal, $tax, $tip){
    $tax_amount = $meal * ($tax /100);
    $tip_amount = $meal *($tip/100);
    $total_notip = $meal + $tax_amount;
    $total_tip = $meal + $tax_amount + $tip_amount;

    return array($total_notip, $total_tip); #can also be return [$x,$y];
}

$totals = restaurant_check(15.22, 8.25, 15);

if($totals[0] < 20){
    print "total with tip is less than 20";
}elseif($totals[1] < 20) {
    print "total without tip is less than 20";
}

print "</br>";

function countdown($counter){
    while($counter > 0){
        print "$counter..";
        $counter--;
    }
    print "boom!<br/>";
}

countdown(6);


// you can use global variables inside a function by using $GLOBALS['variable'];

$dinner = "curry";

function have_dinner(){
    print "first is " . $GLOBALS['dinner']; //doesnt work with just $dinner
    #we can also define it later like
    // global $dinner; not recommended
    global $dinner;
    $dinner = "veggies";
    print ", later at home we have $dinner";

}

have_dinner();

// enforcing types
function getFloat($number): float{
    ///some code
    return 4.5;
}

function countdown2(int $counter){
    while($counter > 0){
        print "$counter..";
        $counter--;
    }
    print "boom!<br/>";
}

// running code in other files.
//we just write at the top
require 'ex3.php';
//include 'ex3.php'; keeps going if there is a problem

//taken from ex2.php
print "<br/>";
countdown3(6);

print "<br/><br/><br/>";
print "<h2>Exercises</h2>";
print "<br/><br/><br/>";

//write function that returns img tag, accepts mandatory url param, and optional alt height and width

function create_img_tag($url, $alt = "an image", $img_width = 100, $img_height = 100){
    print "<img src='$url' alt='$alt' width='$img_width' height='$img_height'></img";
}



?>