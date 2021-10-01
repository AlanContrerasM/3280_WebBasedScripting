<?php
    

    function page_header($color = '#cc3399'){
        print "<html><head><title>My site</title></head>";
        print '<body bgColor="' . $color . '">';

        #return $color;
    }

    function page_footer(){
        print "</body></html>";
    }

    page_header();

    //write function that returns img tag, accepts mandatory url param, and optional alt height and width
    function create_img_tag($url, $alt = "an image", $img_width = 100, $img_height = 100){
        print "<img src='$url' alt='$alt' width='$img_width' height='$img_height'></img>";
    }

    create_img_tag('https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg', 'a php'); 
    //img/flower.jpg if we have files



    //ex2, modify previous function so we use global variables
    $img_url = 'https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg';


    function create_img_tag2($alt = "an image", $img_width = 100, $img_height = 100){
        print "<img src='$GLOBALS[img_url]' alt='$alt' width='$img_width' height='$img_height'></img>";
    }

    create_img_tag2("p to the h to the p",250,250);

    //include a function from another file
    require 'ex3.php';

    countdown3(5);


    page_footer();


?>